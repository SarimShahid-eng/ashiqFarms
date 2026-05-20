<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('head');
            $table->text('sub_head');
            $table->bigInteger('parent_id');
            $table->string('paid_through');
            $table->string('transaction_mode');
            $table->string('bank');
            $table->bigInteger('current_balance');
            $table->bigInteger('balance_in');
            $table->bigInteger('balance_out');
            $table->bigInteger('total_balance');
            $table->string('note');
            $table->text('work_detail');
            $table->softDeletes('deleted_at');
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
        Schema::dropIfExists('transaction');
    }
}
