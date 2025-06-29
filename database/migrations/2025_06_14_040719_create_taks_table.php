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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('task_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('judul_tugas');
            $table->text('deskripsi')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->string('kategori')->nullable();
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->enum('beban_kognitif', ['ringan', 'sedang', 'berat'])->default('sedang');
            $table->enum('status', ['todo', 'inprogress', 'done'])->default('todo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
