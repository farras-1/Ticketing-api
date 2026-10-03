<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('department creation requires authentication', function () {
    $this->postJson('/api/departemen-tujuan', [
        'nama_departemen' => 'Tes',
    ])->assertUnauthorized();
});

test('department creation is forbidden to non-admin users', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $this->postJson('/api/departemen-tujuan', [
        'nama_departemen' => 'Tes',
    ])->assertForbidden();
});

test('admins can create departments', function () {
    $user = User::factory()->create();
    DB::table('users')->where('id', $user->id)->update(['role' => 'admin']);
    $user->refresh();

    Sanctum::actingAs($user);

    $this->postJson('/api/departemen-tujuan', [
        'nama_departemen' => 'Tes',
    ])->assertCreated();
});

test('registration saves the requested role', function () {
    $this->postJson('/api/register', [
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => 'password123',
        'role' => 'admin',
    ])->assertCreated();

    expect(DB::table('users')->where('email', 'admin@example.com')->value('role'))
        ->toBe('admin');
});

test('registration defaults role to user when omitted', function () {
    $this->postJson('/api/register', [
        'name' => 'User',
        'email' => 'user@example.com',
        'password' => 'password123',
    ])->assertCreated();

    expect(DB::table('users')->where('email', 'user@example.com')->value('role'))
        ->toBe('user');
});
