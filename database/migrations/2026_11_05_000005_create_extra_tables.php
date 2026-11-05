<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $t) {
            $t->id();
            $t->string('challenge_name')->nullable();
            $t->text('challenge_description')->nullable();
            $t->text('challenge_rules')->nullable();
            $t->string('challenge_type')->nullable();
            $t->text('challenge_link')->nullable();
            $t->dateTime('challenge_start_date')->nullable();
            $t->dateTime('challenge_end_date')->nullable();
            $t->decimal('challenge_bonus', 20, 8)->default(0);
            $t->unsignedBigInteger('challenge_total')->default(0);
            $t->unsignedBigInteger('influencer_winLength')->default(0);
            $t->unsignedBigInteger('influencer_loseLength')->default(0);
            $t->string('challenge_currency')->nullable();
            $t->string('challenge_provider')->nullable();
            $t->string('challenge_gameid')->nullable();
            $t->timestamps();
        });

        Schema::create('mission_users', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->index();
            $t->unsignedBigInteger('mission_id')->index();
            $t->unsignedBigInteger('rounds')->default(0);
            $t->decimal('rewards', 20, 8)->default(0);
            $t->string('status')->nullable();
            $t->timestamps();
        });

        Schema::create('sub_affiliates', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('affiliate_id')->index();
            $t->unsignedBigInteger('user_id')->index();
            $t->string('status')->nullable();
            $t->timestamps();
        });

        Schema::create('ggds_spin_config', function (Blueprint $t) {
            $t->id();
            $t->json('prizes')->nullable();
            $t->timestamps();
        });

        Schema::create('ggds_spin_runs', function (Blueprint $t) {
            $t->id();
            $t->string('key')->nullable()->index();
            $t->unsignedBigInteger('nonce')->default(0);
            $t->json('possibilities')->nullable();
            $t->text('prize')->nullable();
            $t->timestamps();
        });

        Schema::create('vips', function (Blueprint $t) {
            $t->id();
            $t->string('bet_symbol')->nullable();
            $t->unsignedInteger('bet_level')->default(0);
            $t->decimal('bet_required', 20, 8)->default(0);
            $t->string('bet_period')->nullable();
            $t->decimal('bet_bonus', 20, 8)->default(0);
            $t->timestamps();
        });

        Schema::create('vip_users', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->index();
            $t->unsignedBigInteger('vip_id')->index();
            $t->unsignedInteger('level')->default(0);
            $t->decimal('points', 20, 8)->default(0);
            $t->string('status')->nullable();
            $t->timestamps();
        });

        Schema::create('wallet_changes', function (Blueprint $t) {
            $t->id();
            $t->string('reason')->nullable();
            $t->string('change')->nullable();
            $t->decimal('value_bonus', 20, 8)->default(0);
            $t->decimal('value_total', 20, 8)->default(0);
            $t->decimal('value_roi', 20, 8)->default(0);
            $t->decimal('value_entry', 20, 8)->default(0);
            $t->string('game')->nullable();
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->timestamps();
        });

        Schema::create('system_wallets', function (Blueprint $t) {
            $t->id();
            $t->string('label')->nullable();
            $t->decimal('balance', 20, 8)->default(0);
            $t->decimal('balance_min', 20, 8)->default(0);
            $t->decimal('pay_upto_percentage', 12, 4)->default(0);
            $t->string('mode')->nullable();
            $t->timestamps();
        });

        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->string('session_id')->nullable()->index();
            $t->string('transaction_id')->nullable()->index();
            $t->string('game')->nullable();
            $t->string('game_uuid')->nullable()->index();
            $t->string('type')->nullable();
            $t->string('type_money')->nullable();
            $t->decimal('amount', 20, 8)->default(0);
            $t->string('providers')->nullable();
            $t->boolean('refunded')->default(false);
            $t->string('round_id')->nullable()->index();
            $t->string('status')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('system_wallets');
        Schema::dropIfExists('wallet_changes');
        Schema::dropIfExists('vip_users');
        Schema::dropIfExists('vips');
        Schema::dropIfExists('ggds_spin_runs');
        Schema::dropIfExists('ggds_spin_config');
        Schema::dropIfExists('sub_affiliates');
        Schema::dropIfExists('mission_users');
        Schema::dropIfExists('missions');
    }
};
