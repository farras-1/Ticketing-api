<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->renameIfNeeded('tickets_tables', 'tickets');
        $this->renameIfNeeded('ticket_replies_tables', 'ticket_replies');
    }

    public function down(): void
    {
        $this->renameIfNeeded('ticket_replies', 'ticket_replies_tables');
        $this->renameIfNeeded('tickets', 'tickets_tables');
    }

    private function renameIfNeeded(string $from, string $to): void
    {
        if (Schema::hasTable($from) && Schema::hasTable($to)) {
            throw new RuntimeException("Cannot normalize ticket tables: both {$from} and {$to} exist.");
        }

        if (Schema::hasTable($from)) {
            Schema::rename($from, $to);
        }
    }
};
