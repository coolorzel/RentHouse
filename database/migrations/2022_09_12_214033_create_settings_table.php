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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Name settings site
            $table->string('value')->nullable(); // Name settings site
            $table->char('type', 20)->default('string');
            $table->timestamps();
        });

        /*Schema::create('settings_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id'); // ID of the user who made the changes.
            $table->string('user_location'); // User is location, where the change was made.
            $table->string('user_ip'); // IP address user the change was made
            $table->timestamp('time_change_settings'); // The date and time the change was made
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
        //Schema::dropIfExists('settings_logs');
    }
};
