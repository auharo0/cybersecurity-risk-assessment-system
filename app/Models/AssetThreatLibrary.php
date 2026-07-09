<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetThreatLibrary extends Model
{
    use HasFactory;

    protected $table = 'asset_threat_library';

    protected $primaryKey = 'threat_id';

    protected $fillable = [
        'asset_id',
        'threat_name',
        'threat_description',
        'vulnerabilities',
        'prevention_steps',
        'severity_level',
        'imported_by',
    ];

    // Relationship to Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'asset_id');
    }

    // Relationship to User (who imported)
    public function importer()
    {
        return $this->belongsTo(User::class, 'imported_by');
    }
}
