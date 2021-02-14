<?php

namespace GenesysLite\GenesysFact\Models;

use App\Models\Tenant\Series;
use GenesysLite\GenesysCatalog\Models\DocumentType;
use Illuminate\Database\Eloquent\Model;

class SeriesConfiguration extends Model
{
    protected $fillable = [
        'series_id',
        'series',
        'number',
        'document_type_id',
    ];

    public function relationSeries()
    {
        return $this->belongsTo(Series::class,'series_id');
    }

    public function document_type() {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

}