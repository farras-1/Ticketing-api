<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('an authenticated user can reply to an existing ticket', function () {
    $user = User::factory()->create();
    $categoryId = DB::table('kategori_kendalas')->insertGetId([
        'nama_kategori' => 'Kategori tes',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $departmentId = DB::table('departemen_tujuans')->insertGetId([
        'nama_departemen' => 'Departemen tes',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $ticketId = DB::table('tickets')->insertGetId([
        'ticket_code' => 'TICK-TEST-001',
        'user_id' => $user->id,
        'kategori_id' => $categoryId,
        'departemen_id' => $departmentId,
        'subjek' => 'Subjek tes',
        'deskripsi' => 'Deskripsi tes',
        'prioritas' => 'medium',
        'status' => 'open',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Sanctum::actingAs($user);

    $this->postJson("/api/tickets/{$ticketId}/replies", [
        'pesan' => 'tes',
    ])->assertCreated()
        ->assertJsonPath('data.ticket_id', $ticketId)
        ->assertJsonPath('data.user_id', $user->id)
        ->assertJsonPath('data.pesan', 'tes');
});

test('reply creation returns not found for a missing ticket', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/tickets/999/replies', [
        'pesan' => 'tes',
    ])->assertNotFound();
});
