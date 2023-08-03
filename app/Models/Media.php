<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'path', 'extension', 'mime_type',
        'file_size', 'width', 'height',
    ];
}
