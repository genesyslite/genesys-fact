<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\DocumentType;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Series extends Model
{
    use UsesTenantConnection;
    protected $table = 'series';

    protected $fillable = [
        'establishment_id',
        'document_type_id',
        'number',
        'contingency',
    ];

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function setNumberAttribute($value) {
        $this->attributes['number'] = strtoupper($value);
    }

    public function documents() {
        return $this->hasMany(Document::class, 'series', 'number');
    }

    public function series_configurations()
    {
        return $this->hasOne(SeriesConfiguration::class);
    }



}
