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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->boolean('displayed')->default(false);
            $table->boolean('response')->default(false);
            $table->boolean('closed')->default(false);
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('lname')->nullable();
            $table->bigInteger('u_id')->nullable();
            $table->bigInteger('title_id');
            $table->timestamps();
        });
        Schema::create('contacts_title', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('contacts_control', function (Blueprint $table) {
            $table->id();
            $table->string('information');
            $table->string('message')->nullable();
            $table->bigInteger('message_id');
            $table->bigInteger('viewer_u_id');
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
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('contacts_title');
        Schema::dropIfExists('contacts_control');
    }
};
