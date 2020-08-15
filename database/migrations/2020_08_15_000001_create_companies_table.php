<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('address');
            $table->string('business_id')->nullable()->default(null);
            $table->string('vat_number')->nullable()->default(null);
            $table->string('logo')->nullable()->default(null);
            $table->foreignUuid('user_id')->constrained();
//            $table->foreignUuid('parent_id')->nullable()->default(null)->constrained('companies');
            $table->foreignUuid('parent_id')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
