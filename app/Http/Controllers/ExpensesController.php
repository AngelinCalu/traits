<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('sections.expenses.index', [
            'expenses' => Expense::all()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'amount' => 'required',
            'currency_id' => 'required|uuid',
            'user_id' => 'nullable|required_without:company_id|uuid',
            'company_id' => 'nullable|required_without:user_id|uuid',
            'due_date' => 'required',
            'paid_on' => 'nullable|date',
        ]);

        $expense = Expense::create($attributes);

        if (request()->has('files')) {
            foreach(request()->files as $attachment) {
                $expense->attachments()->create($attachment);
            }
        }

        return redirect('/expenses');
    }

}
