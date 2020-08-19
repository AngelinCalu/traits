<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'original_filename',
        'filename',
        'attachable_id',
        'attachable_type'
    ];

}
