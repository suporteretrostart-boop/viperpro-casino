<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('setting_mails', function (Blueprint $t) {
            $t->id();
            $t->string('software_smtp_type')->nullable();
            $t->string('software_smtp_mail_host')->nullable();
            $t->string('software_smtp_mail_port')->nullable();
            $t->text('software_smtp_mail_username')->nullable();
            $t->text('software_smtp_mail_password')->nullable();
            $t->string('software_smtp_mail_encryption')->nullable();
            $t->string('software_smtp_mail_from_address')->nullable();
            $t->string('software_smtp_mail_from_name')->nullable();
            $t->timestamps();
        });

        Schema::create('banners', function (Blueprint $t) {
            $t->id();
            $t->string('image')->nullable();
            $t->string('type')->nullable();
            $t->text('description')->nullable();
            $t->text('link')->nullable();
            $t->timestamps();
        });

        Schema::create('currencies', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('code');
            $t->string('symbol')->nullable();
            $t->timestamps();
        });

        Schema::create('currency_alloweds', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('currency_id')->index();
            $t->boolean('active')->default(true);
            $t->timestamps();
        });

        Schema::create('gateways', function (Blueprint $t) {
            $t->id();
            $t->text('suitpay_uri')->nullable();
            $t->text('suitpay_cliente_id')->nullable();
            $t->text('suitpay_cliente_secret')->nullable();
            $t->boolean('stripe_production')->default(false);
            $t->text('stripe_public_key')->nullable();
            $t->text('stripe_secret_key')->nullable();
            $t->text('stripe_webhook_key')->nullable();
            $t->text('bspay_uri')->nullable();
            $t->text('bspay_cliente_id')->nullable();
            $t->text('bspay_cliente_secret')->nullable();
            $t->timestamps();
        });

        Schema::create('games_keys', function (Blueprint $t) {
            $t->id();
            foreach ([
                'merchant_url', 'merchant_id', 'merchant_key',
                'games2_agent_code', 'games2_agent_token',
                'games2_agent_secret_key', 'games2_api_endpoint',
                'worldslot_agent_code', 'worldslot_agent_token',
                'worldslot_agent_secret_key', 'worldslot_api_endpoint',
                'agent_code', 'agent_token', 'agent_secret_key',
                'api_endpoint', 'salsa_base_uri', 'salsa_pn',
                'salsa_key', 'vibra_site_id', 'vibra_game_mode'
            ] as $field) {
                $t->text($field)->nullable();
            }
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games_keys');
        Schema::dropIfExists('gateways');
        Schema::dropIfExists('currency_alloweds');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('setting_mails');
    }
};
