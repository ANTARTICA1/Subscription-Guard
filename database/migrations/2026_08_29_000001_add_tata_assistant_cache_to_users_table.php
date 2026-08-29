<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->longText('tata_assistant_data')->nullable()->after('timezone');
            $table->timestamp('tata_assistant_scanned_at')->nullable()->after('tata_assistant_data');
            $table->string('tata_assistant_hash')->nullable()->after('tata_assistant_scanned_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tata_assistant_data', 'tata_assistant_scanned_at', 'tata_assistant_hash']);
        });
    }
};
