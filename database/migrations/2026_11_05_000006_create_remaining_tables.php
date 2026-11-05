<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('custom_layouts', function (Blueprint $t) {
            $t->id();
            $fields = [
                'font_family_default','primary_color','primary_opacity_color',
                'secundary_color','gray_dark_color','gray_light_color',
                'gray_medium_color','gray_over_color','title_color','text_color',
                'sub_text_color','placeholder_color','background_color',
                'background_base','background_base_dark','input_primary',
                'input_primary_dark','carousel_banners','carousel_banners_dark',
                'sidebar_color','sidebar_color_dark','navtop_color',
                'navtop_color_dark','side_menu','side_menu_dark','footer_color',
                'footer_color_dark','card_color','card_color_dark','border_radius'
            ];
            foreach ($fields as $field) $t->text($field)->nullable();
            $t->longText('custom_css')->nullable();
            $t->longText('custom_js')->nullable();
            $t->timestamps();
        });

        foreach (['ggr_games_fivers','ggr_games_world_slots'] as $table) {
            Schema::create($table, function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('user_id')->nullable()->index();
                $t->string('provider')->nullable();
                $t->string('game')->nullable();
                $t->decimal('balance_bet', 20, 8)->default(0);
                $t->decimal('balance_win', 20, 8)->default(0);
                $t->string('currency')->nullable();
                $t->timestamps();
            });
        }

        Schema::create('likes', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->index();
            $t->unsignedBigInteger('liked_user_id')->index();
            $t->timestamps();
        });

        Schema::create('suit_pay_payments', function (Blueprint $t) {
            $t->id();
            $t->string('payment_id')->nullable()->index();
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->unsignedBigInteger('withdrawal_id')->nullable()->index();
            $t->string('pix_key')->nullable();
            $t->string('pix_type')->nullable();
            $t->decimal('amount', 20, 8)->default(0);
            $t->text('observation')->nullable();
            $t->string('status')->nullable();
            $t->timestamps();
        });

        Schema::create('vibra_casino_games', function (Blueprint $t) {
            $t->id();
            $t->string('game_name')->nullable();
            $t->string('game_id')->nullable()->index();
            $t->text('game_cover')->nullable();
            $t->boolean('status')->default(false);
            $t->timestamps();
        });

        Schema::create('permissions', function (Blueprint $t) {
            $t->bigIncrements('id');
            $t->string('name');
            $t->string('guard_name');
            $t->timestamps();
            $t->unique(['name','guard_name']);
        });

        Schema::create('roles', function (Blueprint $t) {
            $t->bigIncrements('id');
            $t->string('name');
            $t->string('guard_name');
            $t->timestamps();
            $t->unique(['name','guard_name']);
        });

        Schema::create('model_has_permissions', function (Blueprint $t) {
            $t->unsignedBigInteger('permission_id');
            $t->string('model_type');
            $t->unsignedBigInteger('model_id');
            $t->index(['model_id','model_type']);
            $t->primary(['permission_id','model_id','model_type']);
            $t->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        Schema::create('model_has_roles', function (Blueprint $t) {
            $t->unsignedBigInteger('role_id');
            $t->string('model_type');
            $t->unsignedBigInteger('model_id');
            $t->index(['model_id','model_type']);
            $t->primary(['role_id','model_id','model_type']);
            $t->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('role_has_permissions', function (Blueprint $t) {
            $t->unsignedBigInteger('permission_id');
            $t->unsignedBigInteger('role_id');
            $t->primary(['permission_id','role_id']);
            $t->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $t->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('vibra_casino_games');
        Schema::dropIfExists('suit_pay_payments');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('ggr_games_world_slots');
        Schema::dropIfExists('ggr_games_fivers');
        Schema::dropIfExists('custom_layouts');
    }
};
