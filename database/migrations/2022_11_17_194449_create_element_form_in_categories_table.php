<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('element_form_in_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cat_id');
            $table->bigInteger('form_id');
            $table->timestamps();
        });

        Schema::create('element_form', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('title');
            $table->boolean('have_options')->default(false);
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
        Schema::dropIfExists('element_form_in_categories');
        Schema::dropIfExists('element_form');
    }
};
