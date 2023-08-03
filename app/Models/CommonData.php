<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class CommonData extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['class', 'title'];

    protected $appends = ['title'];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        $property = 'title_'.$locale;
        return $this->{$property};
    }
}
