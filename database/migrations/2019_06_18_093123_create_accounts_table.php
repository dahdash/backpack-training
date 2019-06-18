<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('office_id');
            $table->string('name');
            $table->double('opening_balance', 15, 2)->default('0.00');
            $table->string('bank_name')->nullable();
            $table->string('bank_phone')->nullable();
            $table->text('bank_address')->nullable();
            $table->boolean('enabled');
            $table->timestamps();

            $table->foreign('office_id')->references('id')->on('offices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
