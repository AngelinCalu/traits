<?php

namespace App\Models;

use App\Http\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use UsesUuid;

    protected $fillable = [
        'name',
        'amount',
        'currency_id',
        'user_id',
        'company_id',
        'due_date',
        'paid_on'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Return the Company associated with the Expense, if any
     */
    public function company() {
        return $this->belongsTo(Company::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Return the User associated with the Expense, if any
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
