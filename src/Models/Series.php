<?php

namespace GenesysLite\GenesysFact\Models;

use GenesysLite\GenesysBusiness\Models\Establishment;
use GenesysLite\GenesysCatalog\Models\DocumentType;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';
    
    protected $fillable = [
        'establishment_id',
        'document_type_id',
        'number',
        'contingency',
    ];
    
    public function establishment() {
        return $this->belongsTo(Establishment::class);
    }
    
    public function document_type() {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
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