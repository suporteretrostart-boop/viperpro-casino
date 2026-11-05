<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->index();
            $t->string('currency')->nullable();
            $t->string('symbol')->nullable();
            foreach (['balance','balance_withdrawal','balance_deposit_rollover','balance_bonus','balance_bonus_rollover','balance_cryptocurrency','balance_demo','refer_rewards','total_bet','total_won','total_lose','last_won','last_lose'] as $field) {
                $t->decimal($field, 20, 8)->default(0);
            }
            $t->boolean('hide_balance')->default(false);
            $t->boolean('active')->default(true);
            $t->unsignedInteger('vip_level')->default(0);
            $t->decimal('vip_points', 20, 8)->default(0);
            $t->timestamps();
        });

        foreach (['deposits', 'withdrawals', 'affiliate_withdraws'] as $table) {
            Schema::create($table, function (Blueprint $t) {
                $t->id();
                $t->string('payment_id')->nullable()->index();
                $t->unsignedBigInteger('user_id')->nullable()->index();
                $t->decimal('amount', 20, 8)->default(0);
                $t->string('type')->nullable();
                $t->text('bank_info')->nullable();
                $t->text('proof')->nullable();
                $t->string('pix_key')->nullable();
                $t->string('pix_type')->nullable();
                $t->string('currency')->nullable();
                $t->string('symbol')->nullable();
                $t->string('status')->nullable();
                $t->timestamps();
            });
        }

        Schema::create('transactions', function (Blueprint $t) {
            $t->id();
            $t->string('payment_id')->nullable()->index();
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->string('payment_method')->nullable();
            $t->decimal('price', 20, 8)->default(0);
            $t->string('currency')->nullable();
            $t->string('status')->nullable();
            $t->timestamps();
        });

        Schema::create('affiliate_histories', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->unsignedBigInteger('inviter')->nullable()->index();
            $t->decimal('commission', 20, 8)->default(0);
            $t->string('commission_type')->nullable();
            $t->unsignedBigInteger('deposited')->default(0);
            $t->decimal('deposited_amount', 20, 8)->default(0);
            $t->unsignedBigInteger('losses')->default(0);
            $t->decimal('losses_amount', 20, 8)->default(0);
            $t->decimal('commission_paid', 20, 8)->default(0);
            $t->string('status')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_histories');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('affiliate_withdraws');
        Schema::dropIfExists('withdrawals');
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('wallets');
    }
};
