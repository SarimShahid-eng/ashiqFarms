<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bank_id')->nullable(false);
            $table->bigInteger('bank_branch_id')->nullable(false);
            $table->bigInteger('customer_id')->nullable(false);
            $table->bigInteger('transaction_id')->nullable(false);
            $table->integer('amount')->nullable(false);
            $table->string('type',10)->nullable(false);
            $table->text('note')->nullable();
            $table->string('column_color',250)->nullable();
            $table->date('balance_date');
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
        Schema::dropIfExists('balances');
    }
}
