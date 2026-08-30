<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('timezone');
            }
            if (!Schema::hasColumn('users', 'account_number')) {
                $table->string('account_number')->nullable()->after('bank_name');
            }
            if (!Schema::hasColumn('users', 'account_holder')) {
                $table->string('account_holder')->nullable()->after('account_number');
            }
        });

        Schema::table('subscription_shares', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_shares', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('subscription_shares', 'rejection_reason')) {
                $table->string('rejection_reason')->nullable()->after('payment_proof_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'account_number', 'account_holder']);
        });

        Schema::table('subscription_shares', function (Blueprint $table) {
            $table->dropColumn(['paid_at', 'rejection_reason']);
        });
    }
};
