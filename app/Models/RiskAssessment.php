<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskAssessment extends Model
{
    protected $primaryKey = 'assessment_id';

    // Map Laravel's created_at to our custom column name
    const CREATED_AT = 'assessment_date';
    const UPDATED_AT = null;

    protected $fillable = [
        'session_id',
        'asset_id',
        'assessed_by',
        'threat_description',
        'vulnerability_description',
        'cve_reference',
        'likelihood',
        'impact',
        'risk_score',
        'risk_classification',
        'status',
        'mitigation_plan',
    ];

    // Relationships
    public function session(): BelongsTo
    {
        return $this->belongsTo(AssessmentSession::class, 'session_id', 'session_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'asset_id');
    }

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assessed_by', 'id');
    }
}
