<?php

namespace App\Models;

use App\Http\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use UsesUuid;

    protected $fillable = [
        'name',
        'address',
        'business_id',
        'vat_number',
        'logo',
        'user_id',
        'parent_id'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * Return the expenses associated with the Company
     */
    public function expenses() {
        return $this->hasMany(Expense::class);
    }
}
