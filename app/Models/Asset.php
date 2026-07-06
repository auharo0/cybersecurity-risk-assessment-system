<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $primaryKey = 'asset_id';
    const UPDATED_AT = null;

    protected $fillable = [
        'asset_name',
        'asset_type',
        'description',
        'managed_by',
        'session_id',
    ];

    // Relationships
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'managed_by', 'id');
    }

    public function assessmentSession(): BelongsTo
    {
        return $this->belongsTo(AssessmentSession::class, 'session_id', 'session_id');
    }

    public function riskAssessments(): HasMany
    {
        return $this->hasMany(RiskAssessment::class, 'asset_id', 'asset_id');
    }
}
