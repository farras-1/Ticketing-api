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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_kendalas')->onDelete('cascade');
            $table->foreignId('departemen_id')->constrained('departemen_tujuans')->onDelete('cascade');
            $table->string('subjek');
            $table->text('deskripsi');
            $table->enum('prioritas', ['low', 'medium', 'high', 'urgent']);
            $table->enum('status', ['open', 'on_progres', 'resolved', 'closed']);
            $table->foreignid('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('tickets_tables');
    }
};
