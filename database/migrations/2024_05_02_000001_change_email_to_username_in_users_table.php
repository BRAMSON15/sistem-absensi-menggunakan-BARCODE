<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add username column first
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
        });

        // Copy email data to username (extract username from email)
        DB::table('users')->get()->each(function ($user) {
            $username = explode('@', $user->email)[0];
            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => $username]);
        });

        // Drop email column and email_verified_at
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropColumn(['email', 'email_verified_at']);
        });

        // Update password_reset_tokens table
        if (Schema::hasTable('password_reset_tokens')) {
            // Add username column
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->string('username')->after('email');
            });

            // Copy email to username
            DB::table('password_reset_tokens')->get()->each(function ($token) {
                $username = explode('@', $token->email)[0];
                DB::table('password_reset_tokens')
                    ->where('email', $token->email)
                    ->update(['username' => $username]);
            });

            // Drop email column and recreate primary key
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->dropPrimary(['email']);
            });

            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->dropColumn('email');
            });

            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->primary('username');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add email column back
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->after('username');
            $table->timestamp('email_verified_at')->nullable()->after('email');
        });

        // Copy username to email
        DB::table('users')->get()->each(function ($user) {
            $email = $user->username . '@sma.com';
            DB::table('users')
                ->where('id', $user->id)
                ->update(['email' => $email]);
        });

        // Drop username column
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });

        // Revert password_reset_tokens table
        if (Schema::hasTable('password_reset_tokens')) {
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->dropPrimary(['username']);
            });

            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->after('username');
            });

            DB::table('password_reset_tokens')->get()->each(function ($token) {
                $email = $token->username . '@sma.com';
                DB::table('password_reset_tokens')
                    ->where('username', $token->username)
                    ->update(['email' => $email]);
            });

            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->dropColumn('username');
            });

            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->primary('email');
            });
        }
    }
};
