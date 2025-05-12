<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // school ID (credits owner)
            $table->unsignedBigInteger('performed_by')->nullable(); // who triggered it (e.g., teacher)
            $table->integer('amount'); // positive integer
            $table->enum('type', ['debit', 'credit']); // debit or credit
            $table->string('reason')->nullable(); // reason for transaction
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_transactions');
    }
}
