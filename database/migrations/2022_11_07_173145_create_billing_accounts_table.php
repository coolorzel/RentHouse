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
        Schema::create('billing_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('u_id');
            $table->boolean('company');
            $table->boolean('verified')->default(false);
            $table->boolean('rejected')->default(false);
            $table->boolean('destroy')->default(false);
            $table->string('name');
            $table->string('lname');
            $table->string('pesel');
            $table->string('phone_number');
            $table->string('country');
            $table->string('province');
            $table->string('city');
            $table->string('street');
            $table->string('building_number');
            // FOR Company //
            $table->string('company_name');
            $table->string('company_nip');
            $table->string('company_website');
            $table->foreign('u_id') // Tworzenie relacji. Określenie kolumny z tej tabeli
            ->references('id') // Określenie kolumny z tabeli zewnętrznej
            ->on('users') // Określenie, z którą tabelą ma zostać stworzona relacja.
            ->onDelete('cascade'); // Usuwanie kaskadowe
            $table->timestamps();
        });

        Schema::create('billing_application', function (Blueprint $table) {
            $table->id();
            $table->boolean('displayed')->default(false);
            $table->unsignedbigInteger('billing_id');
            $table->string('message')->nullable();
            $table->unsignedbigInteger('sender');
            $table->foreign('billing_id') // Tworzenie relacji. Określenie kolumny z tej tabeli
            ->references('id') // Określenie kolumny z tabeli zewnętrznej
            ->on('billing_accounts') // Określenie, z którą tabelą ma zostać stworzona relacja.
            ->onDelete('cascade'); // Usuwanie kaskadowe
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
        Schema::dropIfExists('billing_accounts');
        Schema::dropIfExists('billing_application');
    }
};
