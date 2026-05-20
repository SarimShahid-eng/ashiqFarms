<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->bigInteger('head_id')->nullable();
            $table->bigInteger('subhead_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('schedule_id')->nullable();
            $table->string('work',255)->nullable();
            $table->string('acres',255)->nullable();
            $table->text('material')->nullable();
            $table->string('quantity',255)->nullable();
            $table->string('unit_rate',255)->nullable();
            $table->string('total',255)->nullable();
            $table->string('payment_type',255)->nullable();
            $table->text('note')->nullable();
            $table->string('column_color',255)->nullable();
            $table->date('expense_date')->nullable();
            $table->date('end_date')->nullable();
            $table->softDeletes('deleted_at')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
