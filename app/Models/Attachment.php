<?php

namespace App\Models;

use App\Http\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{

    use UsesUuid;

    protected $fillable = [
        'original_filename',
        'filename',
        'attachable_id',
        'attachable_type',
        'type',
        'size'
    ];

}
