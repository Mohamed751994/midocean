<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function parentable() {
        return $this->morphTo();
    }

    public function getUrlAttribute($value)
    {
        $folderName = str_replace('App\Models\\','', $this->parentable_type);
        $pluralFolderName = strtolower(Str::plural($folderName));
        return asset('/uploads/'.$pluralFolderName.'/'.$value);
    }

}
