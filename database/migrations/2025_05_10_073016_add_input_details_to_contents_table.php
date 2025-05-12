<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputDetailsToContentsTable extends Migration
{
    public function up()
    {
        Schema::table('content', function (Blueprint $table) {
            $table->string('topic')->nullable()->after('type');
            $table->string('grade_level')->nullable()->after('topic');
            $table->integer('num_questions')->nullable()->after('grade_level');
            $table->string('question_type')->nullable()->after('num_questions');
            $table->integer('duration')->nullable()->after('question_type'); // For lesson plans
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn(['topic', 'grade_level', 'num_questions', 'question_type', 'duration']);
        });
    }
}