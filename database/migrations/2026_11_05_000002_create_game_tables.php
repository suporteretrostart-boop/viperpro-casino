<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $t) {
            $t->id();
            $t->string('code')->nullable();
            $t->string('name');
            $t->decimal('rtp', 8, 2)->nullable();
            $t->boolean('status')->default(true);
            $t->string('distribution')->nullable();
            $t->unsignedBigInteger('views')->default(0);
            $t->timestamps();
        });

        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->text('description')->nullable();
            $t->string('image')->nullable();
            $t->string('slug')->nullable()->index();
            $t->timestamps();
        });

        Schema::create('games', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('provider_id')->nullable()->index();
            $t->text('game_server_url')->nullable();
            $t->string('game_id')->nullable()->index();
            $t->string('game_name');
            $t->string('game_code')->nullable()->index();
            $t->string('game_type')->nullable();
            $t->text('description')->nullable();
            $t->string('cover')->nullable();
            $t->boolean('status')->default(false);
            $t->string('technology')->nullable();
            $t->boolean('has_lobby')->default(false);
            $t->boolean('is_mobile')->default(true);
            $t->boolean('has_freespins')->default(false);
            $t->boolean('has_tables')->default(false);
            $t->boolean('only_demo')->default(false);
            $t->decimal('rtp', 8, 2)->nullable();
            $t->string('distribution')->nullable();
            $t->unsignedBigInteger('views')->default(0);
            $t->boolean('is_featured')->default(false);
            $t->boolean('show_home')->default(false);
            $t->timestamps();
        });

        Schema::create('category_game', function (Blueprint $t) {
            $t->unsignedBigInteger('category_id');
            $t->unsignedBigInteger('game_id');
            $t->primary(['category_id', 'game_id']);
        });

        Schema::create('game_favorites', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->index();
            $t->unsignedBigInteger('game_id')->index();
            $t->timestamps();
        });

        Schema::create('game_likes', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->index();
            $t->unsignedBigInteger('game_id')->index();
            $t->timestamps();
        });

        Schema::create('game_reviews', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->index();
            $t->unsignedBigInteger('game_id')->index();
            $t->text('description')->nullable();
            $t->unsignedTinyInteger('rating')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_reviews');
        Schema::dropIfExists('game_likes');
        Schema::dropIfExists('game_favorites');
        Schema::dropIfExists('category_game');
        Schema::dropIfExists('games');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('providers');
    }
};
