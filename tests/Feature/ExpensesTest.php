<?php

namespace Tests\Feature;

use App\Http\Traits\HasAttachments;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExpensesTest extends TestCase
{

    use WithFaker, RefreshDatabase;


    /**  @test */
    public function a_user_can_create_an_expense_without_an_attachment()
    {
        $this->withoutExceptionHandling();

        $attributes = factory('App\Models\Expense')->raw();

        $this->post('/expenses', $attributes)->assertRedirect('/expenses');

        $this->assertDatabaseHas('expenses', $attributes);

        $this->get('/expenses')->assertSee($attributes['name']);
    }


    /** @test */
    public function expenses_uses_has_attachments_trait_users_dont()
    {
        $uses_trait = array_key_exists(
            HasAttachments::class,
            class_uses_recursive(Expense::class)
        );

        $doesnt_use_trait = array_key_exists(
            HasAttachments::class,
            class_uses_recursive(User::class)
        );

        $this->assertTrue($uses_trait);
        $this->assertNotTrue($doesnt_use_trait);

    }

    /** @test */
    public function a_file_can_be_attached_on_expenses_creation()
    {
        $this->withoutExceptionHandling();

        Storage::fake('expenses');

        $attributes = factory('App\Models\Expense')->raw();

        $attributes['files'] = [
            UploadedFile::fake()->image('file1.png')
        ];

        $response = $this->json('post', '/expenses', $attributes)->assertRedirect('/expenses');

        Storage::disk('expenses')->assertExists(['file1.png']);
        Storage::disk('expenses')->assertMissing('missing.pdf');

        $response->assertStatus(201);
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
