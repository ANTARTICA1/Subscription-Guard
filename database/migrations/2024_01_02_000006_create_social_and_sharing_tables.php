<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'user_tag')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_tag')->nullable()->unique()->after('id');
            });
        }

        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });

        Schema::create('subscription_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('friend_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('friend_name')->nullable();
            $table->decimal('split_amount', 15, 2);
            $table->enum('payment_status', ['paid', 'pending', 'overdue'])->default('pending');
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_shares');
        Schema::dropIfExists('friendships');
        if (Schema::hasColumn('users', 'user_tag')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('user_tag');
            });
        }
    }
};
