<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermintaanRequest;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class PermintaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $items = Permintaan::latest()->paginate(10);
        } else {
            $items = Permintaan::where('user_id', $user->id)->latest()->paginate(10);
        }
        return view('permintaan.index', compact('items'));
    }

    // Show request history for the authenticated user (or all for admin)
    public function history()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $items = Permintaan::latest()->paginate(20);
        } else {
            $items = Permintaan::where('user_id', $user->id)->latest()->paginate(20);
        }
        return view('permintaan.history', compact('items'));
    }

    public function create()
    {
        return view('permintaan.create');
    }

    public function store(StorePermintaanRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        // handle attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file->isValid()) continue;
                $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploader'), $name);
                $attachments[] = $name;
            }
        }
        if ($attachments) $data['attachments'] = $attachments;

        // meta: include quantity
        $meta = $data['meta'] ?? [];
        if (isset($data['quantity'])) $meta['quantity'] = $data['quantity'];
        $data['meta'] = $meta;

        $permintaan = Permintaan::create($data);
        return redirect()->route('permintaan.edit', $permintaan)->with('success', 'Permintaan dibuat');
    }

    public function show(Permintaan $permintaan)
    {
        $this->authorizeView($permintaan);
        return view('permintaan.show', compact('permintaan'));
    }

    public function edit(Permintaan $permintaan)
    {
        $this->authorizeView($permintaan);
        return view('permintaan.edit', compact('permintaan'));
    }

    public function update(StorePermintaanRequest $request, Permintaan $permintaan)
    {
        $this->authorizeView($permintaan);
        $data = $request->validated();
        
        // handle attachments append
        $attachments = $permintaan->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file->isValid()) continue;
                $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploader'), $name);
                $attachments[] = $name;
            }
        }
        if ($attachments) $data['attachments'] = $attachments;
        
        // meta: include quantity
        $meta = $permintaan->meta ?? [];
        if (isset($data['quantity'])) $meta['quantity'] = $data['quantity'];
        $data['meta'] = $meta;
        
        $permintaan->update($data);
        return redirect()->route('permintaan.edit', $permintaan)->with('success', 'Permintaan diperbarui');
    }

    public function destroy(Permintaan $permintaan)
    {
        $this->authorizeView($permintaan);
        $permintaan->delete();
        return redirect()->route('permintaan.index')->with('success', 'Permintaan dihapus');
    }

    // Delete a single attachment by filename
    public function deleteAttachment(Request $request, Permintaan $permintaan, $filename)
    {
        $this->authorizeView($permintaan);

        $attachments = $permintaan->attachments ?? [];
        $filtered = array_values(array_filter($attachments, function($a) use ($filename) {
            return $a !== $filename;
        }));

        // remove file on disk
        $path = public_path('uploader/' . $filename);
        if (file_exists($path)) @unlink($path);

        $permintaan->attachments = $filtered;
        $permintaan->save();

        return redirect()->back()->with('success', 'Lampiran dihapus');
    }

    // Autosave endpoint used by JS — creates or updates the resource with partial data
    public function autosave(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only(['judul', 'deskripsi', 'status', 'meta']);
        $user = auth()->user();

        if ($id) {
            $permintaan = Permintaan::find($id);
            if ($permintaan) {
                if ($user->role !== 'admin' && $permintaan->user_id !== $user->id) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
                $permintaan->update($data);
            } else {
                $permintaan = Permintaan::create(array_merge($data, ['status' => $data['status'] ?? 'draft', 'user_id' => $user->id]));
            }
        } else {
            $permintaan = Permintaan::create(array_merge($data, ['status' => $data['status'] ?? 'draft', 'user_id' => $user->id]));
        }

        return response()->json(['id' => $permintaan->id, 'saved_at' => $permintaan->updated_at]);
    }

    /**
     * Preview selected permintaan before export/download.
     * Accepts query param `ids` as comma separated list.
     */
    public function preview(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $items = Permintaan::whereIn('id', $ids)->get();
        return view('permintaan.preview', compact('items'));
    }

    /**
     * Export selected permintaan as CSV (or simple Excel-compatible CSV).
     * POST with `ids[]` and `format` (csv|xlsx)
     */
    public function export(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403);
        }

        $ids = $request->input('ids', []);
        $format = $request->input('format', 'csv');

        if (!empty($ids)) {
            $items = Permintaan::whereIn('id', $ids)->get();
        } else {
            $query = Permintaan::query();
            if ($from = $request->input('from')) {
                try {
                    $query->where('created_at', '>=', Carbon::parse($from)->startOfDay());
                } catch (Exception $e) {
                    // ignore parse errors
                }
            }
            if ($to = $request->input('to')) {
                try {
                    $query->where('created_at', '<=', Carbon::parse($to)->endOfDay());
                } catch (Exception $e) {
                    // ignore parse errors
                }
            }
            $items = $query->get();
        }

        $filename = 'permintaan_export_'.date('Ymd_His').'.'.($format === 'xlsx' ? 'xlsx' : 'csv');

        $columns = [
            'ID','Judul','Deskripsi','User','Category','Priority','Asset Tag','Hardware Type','Location','Status','Requested At','Assigned To','Approver','Approved At','Approval Note','Estimated Completion'
        ];

        $callback = function() use ($items, $columns) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM to help Excel open CSV with proper encoding
            fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, $columns);
            foreach ($items as $item) {
                fputcsv($out, [
                    $item->id,
                    $item->judul,
                    $item->deskripsi,
                    optional($item->user)->name,
                    $item->category,
                    $item->priority,
                    $item->asset_tag,
                    $item->hardware_type,
                    $item->location,
                    $item->status,
                    $item->requested_at,
                    optional($item->assignedTo)->name ?? null,
                    optional($item->approver)->name ?? null,
                    $item->approved_at,
                    $item->approval_note,
                    $item->estimated_completion,
                ]);
            }
            fclose($out);
        };

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response()->stream($callback, 200, $headers);
    }

    protected function authorizeView(Permintaan $permintaan)
    {
        $user = auth()->user();
        if ($user->role === 'admin') return true;
        if ($permintaan->user_id === $user->id) return true;
        abort(403, 'Unauthorized');
    }
}
