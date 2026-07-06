<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentSession extends Model
{
    protected $primaryKey = 'session_id';
    const UPDATED_AT = null;

    protected $fillable = [
        'session_name',
        'status',
        'created_by',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'session_id', 'session_id');
    }

    public function riskAssessments(): HasMany
    {
        return $this->hasMany(RiskAssessment::class, 'session_id', 'session_id');
    }
}
