<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('avatar')) {
            // delete old avatar if exists
            if ($user->avatar && file_exists(public_path('uploader/avatars/' . $user->avatar))) {
                @unlink(public_path('uploader/avatars/' . $user->avatar));
            }

            $file = $request->file('avatar');
            $ext = $file->getClientOriginalExtension();
            $filename = Str::random(12) . '.' . $ext;
            $dest = public_path('uploader/avatars');
            if (!file_exists($dest)) mkdir($dest, 0755, true);

            // move uploaded file first
            $tmpPath = $file->getRealPath();
            $tmpDest = $dest . DIRECTORY_SEPARATOR . $filename;
            // Simple GD resize to 300x300 max
            list($w, $h) = getimagesize($tmpPath);
            $max = 300;
            $ratio = min($max / $w, $max / $h, 1);
            $newW = (int)($w * $ratio);
            $newH = (int)($h * $ratio);

            $srcImg = null;
            if (in_array(strtolower($ext), ['jpg','jpeg'])) $srcImg = imagecreatefromjpeg($tmpPath);
            elseif (strtolower($ext) === 'png') $srcImg = imagecreatefrompng($tmpPath);
            elseif (strtolower($ext) === 'webp' && function_exists('imagecreatefromwebp')) $srcImg = imagecreatefromwebp($tmpPath);

            if ($srcImg) {
                $dstImg = imagecreatetruecolor($newW, $newH);
                // preserve transparency for PNG
                if (strtolower($ext) === 'png') {
                    imagealphablending($dstImg, false);
                    imagesavealpha($dstImg, true);
                }
                imagecopyresampled($dstImg, $srcImg, 0,0,0,0, $newW, $newH, $w, $h);
                if (in_array(strtolower($ext), ['jpg','jpeg'])) imagejpeg($dstImg, $tmpDest, 85);
                elseif (strtolower($ext) === 'png') imagepng($dstImg, $tmpDest);
                elseif (strtolower($ext) === 'webp' && function_exists('imagewebp')) imagewebp($dstImg, $tmpDest);
                imagedestroy($srcImg);
                imagedestroy($dstImg);
            } else {
                // fallback to move
                $file->move($dest, $filename);
            }

            $user->avatar = $filename;
        }

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil diperbarui.');
    }

    public function destroyAvatar(Request $request)
    {
        $user = Auth::user();
        if ($user->avatar && file_exists(public_path('uploader/avatars/' . $user->avatar))) {
            @unlink(public_path('uploader/avatars/' . $user->avatar));
        }
        $user->avatar = null;
        $user->save();
        return redirect()->back()->with('success', 'Avatar dihapus');
    }
}
