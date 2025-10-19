<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaans';

    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'meta',
        'user_id',
        'category',
        'priority',
        'asset_tag',
        'hardware_type',
        'location',
        'requested_at',
        'assigned_to',
        'approver_id',
        'approved_at',
        'approval_note',
        'estimated_completion',
        'attachments',
    ];

    protected $casts = [
        'meta' => 'array',
        'attachments' => 'array',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'estimated_completion' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approver_id');
    }
}

