<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $primaryKey = 'log_id';

    // Disable the default updated_at column since your schema only uses created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
