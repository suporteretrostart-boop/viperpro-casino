<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('role_id')->nullable();
            $t->string('avatar')->nullable();
            $t->string('name');
            $t->string('last_name')->nullable();
            $t->string('cpf')->nullable()->unique();
            $t->string('phone')->nullable();
            $t->string('email')->unique();
            $t->timestamp('email_verified_at')->nullable();
            $t->string('password');
            $t->rememberToken();
            $t->boolean('logged_in')->default(false);
            $t->boolean('banned')->default(false);
            $t->unsignedBigInteger('inviter')->nullable();
            $t->string('inviter_code')->nullable()->index();
            $t->decimal('affiliate_revenue_share', 12, 4)->default(0);
            $t->decimal('affiliate_revenue_share_fake', 12, 4)->default(0);
            $t->decimal('affiliate_cpa', 12, 4)->default(0);
            $t->decimal('affiliate_baseline', 12, 4)->default(0);
            $t->boolean('is_demo_agent')->default(false);
            $t->boolean('is_admin')->default(false);
            $t->string('language')->nullable();
            $t->string('oauth_id')->nullable();
            $t->string('oauth_type')->nullable();
            $t->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $t) {
            $t->string('email')->primary();
            $t->string('token');
            $t->timestamp('created_at')->nullable();
        });

        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('software_name')->nullable();
            $t->text('software_description')->nullable();
            $t->string('software_favicon')->nullable();
            $t->string('software_logo_white')->nullable();
            $t->string('software_logo_black')->nullable();
            $t->string('software_background')->nullable();
            $t->string('currency_code')->nullable();
            $t->string('decimal_format')->nullable();
            $t->string('currency_position')->nullable();
            $t->string('prefix')->nullable();
            $t->string('storage')->nullable();
            $t->decimal('min_deposit', 20, 8)->default(0);
            $t->decimal('max_deposit', 20, 8)->default(0);
            $t->decimal('min_withdrawal', 20, 8)->default(0);
            $t->decimal('max_withdrawal', 20, 8)->default(0);
            $t->decimal('bonus_vip', 12, 4)->default(0);
            $t->boolean('activate_vip_bonus')->default(false);
            $t->decimal('ngr_percent', 12, 4)->default(0);
            $t->decimal('revshare_percentage', 12, 4)->default(0);
            $t->boolean('revshare_reverse')->default(false);
            $t->decimal('soccer_percentage', 12, 4)->default(0);
            $t->boolean('turn_on_football')->default(false);
            $t->decimal('initial_bonus', 20, 8)->default(0);
            $t->decimal('rollover', 12, 4)->default(0);
            $t->decimal('rollover_deposit', 12, 4)->default(0);
            $t->boolean('suitpay_is_enable')->default(false);
            $t->boolean('stripe_is_enable')->default(false);
            $t->boolean('bspay_is_enable')->default(false);
            $t->decimal('withdrawal_limit', 20, 8)->default(0);
            $t->string('withdrawal_period')->nullable();
            $t->boolean('disable_spin')->default(false);
            $t->decimal('perc_sub_lv1', 12, 4)->default(0);
            $t->decimal('perc_sub_lv2', 12, 4)->default(0);
            $t->decimal('perc_sub_lv3', 12, 4)->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
