<?php

namespace App\Entities;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected static function booted()
    {
        static::deleted(function ($document) {
            Storage::delete('documents/'.$document->id);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','filename','extension','type',
    ];

    public function getPathAttribute()
    {
        if($this->id)
            return storage_path('app/documents/'.$this->id.'.'.$this->extension);
    }


    /*
    |--------------------------------------------------------------------------
    | Model Query Scopes
    |--------------------------------------------------------------------------
    |
    |
    */
    public function scopeCV($query)
    {
        $query->where('type','cv');
    }

    public function scopePicture($query)
    {
        $query->where('type','picture');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    |
    |
    */

    public function user()
    {
        return $this->belongsTo('App\Entities\User')->withDefault();
    }
}
