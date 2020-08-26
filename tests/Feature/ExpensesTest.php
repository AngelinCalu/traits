<?php

namespace Tests\Feature;

use App\Http\Traits\HasAttachments;
use App\Models\Attachment;
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

    /**  @test */
    public function a_user_can_create_an_expense_without_an_attachment()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory(User::class)->create());

        $attributes = factory('App\Models\Expense')->raw();

        $this->post('/expenses', $attributes)->assertRedirect('/expenses');

        $this->assertDatabaseHas('expenses', $attributes);

        $this->get('/expenses')->assertSee($attributes['name']);
    }


    /** @test */
    public function a_file_can_be_attached_on_expenses_creation()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory(User::class)->create());

        Storage::fake('local');

        $attributes = factory('App\Models\Expense')->raw();

        // Add attachment to post request array
        $attributes['files'] = [
            UploadedFile::fake()->image('file1.png')
        ];

        $this->post('/expenses', $attributes)->assertRedirect('/expenses');

        // Remove the attachment from the request array
        unset($attributes['files']);

        $this->assertDatabaseHas('expenses', $attributes);

        $attachment = Attachment::where('attachable_id', Expense::where('name', $attributes['name'])->first()->id)->first();

        Storage::disk('local')->assertExists([$attachment->filename]);
        Storage::disk('local')->assertMissing('missing.pdf');

    }


    /**  @test */
    public function an_expense_requires_a_name()
    {
        $this->actingAs(factory(User::class)->create());

        $attributes = factory('App\Models\Expense')->raw(['name' => '']);

        $this->post('/expenses', $attributes)->assertSessionHasErrors('name');
    }

    /**  @test */
    public function an_expense_requires_an_amount()
    {
        $this->actingAs(factory(User::class)->create());

        $attributes = factory('App\Models\Expense')->raw(['amount' => '']);

        $this->post('/expenses', $attributes)->assertSessionHasErrors('amount');
    }


    /**  @test */
    public function an_expense_requires_a_currency()
    {
        $this->actingAs(factory(User::class)->create());

        $attributes = factory('App\Models\Expense')->raw(['currency_id' => '']);

        $this->post('/expenses', $attributes)->assertSessionHasErrors('currency_id');
    }

    /**  @test */
    public function an_expense_requires_a_due_date()
    {
        $this->actingAs(factory(User::class)->create());

        $attributes = factory('App\Models\Expense')->raw(['due_date' => '']);

        $this->post('/expenses', $attributes)->assertSessionHasErrors('due_date');
    }


}
