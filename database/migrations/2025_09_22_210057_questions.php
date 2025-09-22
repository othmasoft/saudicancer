<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question'); // السؤال
            $table->boolean('correct_answer'); // الإجابة الصحيحة (1 = نعم, 0 = لا)
            $table->text('explanation')->nullable(); // شرح الإجابة
            $table->boolean('is_active')->default(true); // السؤال نشط
            $table->integer('order')->default(0); // ترتيب السؤال
            $table->timestamps();

            // Indexes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
