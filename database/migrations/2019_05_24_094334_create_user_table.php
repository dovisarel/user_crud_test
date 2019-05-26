<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->string('email', 254);
            $table->string('username', 45);
            $table->string('password', 32);
            $table->timestamp('created_at');
            $table->dateTime('last_updated_time')->useCurrent();
            $table->boolean('is_active')->default(1);
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
