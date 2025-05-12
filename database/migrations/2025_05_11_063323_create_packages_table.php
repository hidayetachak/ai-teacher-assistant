<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('is_active')->default(1);
            $table->integer('is_featured')->default(0);
            $table->string('recovery_payment', 255);
            $table->integer('duration')->comment('Duration in days');
            $table->integer('credits')->default(0)->comment('Number of allowed credits');
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
        Schema::dropIfExists('packages');
    }
}
