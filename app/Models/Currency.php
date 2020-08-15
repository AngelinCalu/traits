<?php

namespace App\Models;

use App\Http\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use UsesUuid;

    protected $guarded = [];
}
