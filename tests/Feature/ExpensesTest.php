<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpensesTest extends TestCase
{

    use WithFaker, RefreshDatabase;


    /**  @test */
    public function a_user_can_create_an_expense()
    {

        $this->withoutExceptionHandling();

        $attributes = factory('App\Models\Expense')->raw();

        $this->post('/expenses', $attributes)->assertRedirect('/expenses');

        $this->assertDatabaseHas('expenses', $attributes);

        $this->get('/expenses')->assertSee($attributes['name']);
    }


    /**  @test */
    public function an_expense_requires_a_name()
    {
        $attributes = factory('App\Models\Expense')->make(['name' => '']);

        $this->post('/expenses', $attributes)->assertSessionHasErrors('name');
    }

    /**  @test */
    public function an_expense_requires_an_amount()
    {
        $attributes = factory('App\Models\Expense')->make(['amount' => '']);

        $this->post('/expenses', $attributes)->assertSessionHasErrors('amount');
    }


    /**  @test */
    public function an_expense_requires_a_currency()
    {
        $attributes = factory('App\Models\Expense')->make(['currency_id' => '']);

        $this->post('/expenses', $attributes)->assertSessionHasErrors('amount');
    }

    /**  @test */
    public function an_expense_requires_a_due_date()
    {
        $attributes = factory('App\Models\Expense')->make(['due_date' => '']);

        $this->post('/expenses', $attributes)->assertSessionHasErrors('amount');
    }


}
