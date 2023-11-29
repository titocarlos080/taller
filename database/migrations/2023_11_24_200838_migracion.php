<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('rols', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->foreignId('current_team_id')->nullable();
        //     $table->string('profile_photo_path', 2048)->nullable();
        //     $table->timestamps();
        //     $table->unsignedBigInteger('rol_id')->nullable()->foreign('rol_id')->references('id')->on('rols')->onDelete('set null');
        // });
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->text('location')->nullable();
            $table->string('contact_info')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('workshop_id')->nullable()->foreign('workshop_id')->references('id')->on('workshops')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable()->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('year')->nullable();
            $table->string('licence_plate')->nullable();
            $table->unsignedBigInteger('client_id')->nullable()->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('assistance_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable()->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->unsignedBigInteger('vehicle_id')->nullable()->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            $table->unsignedBigInteger('status_id')->nullable()->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
            $table->string('problem_description')->nullable();
            $table->decimal('latitud', 12, 5)->nullable();
            $table->decimal('longitud', 12, 5)->nullable();
            $table->text('photos')->nullable();
            $table->text('voice_note')->nullable();
            $table->timestamps();
        });
        Schema::create('assistance_requests_workshop', function (Blueprint $table) {
            $table->id();
            $table->float('price')->nullable();
            $table->unsignedBigInteger('workshop_id')->nullable()->foreign('workshop_id')->references('id')->on('workshops')->onDelete('set null');
            $table->unsignedBigInteger('technician_id')->nullable()->foreign('technician_id')->references('id')->on('technicians')->onDelete('set null');
            $table->unsignedBigInteger('assistance_request_id')->nullable()->foreign('assistance_request_id')->references('id')->on('assistance_requests')->onDelete('set null');
            $table->timestamps();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')
                    ->after('two_factor_recovery_codes')
                    ->nullable();
            }
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
     

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'two_factor_secret',
                'two_factor_recovery_codes',
            ], Fortify::confirmsTwoFactorAuthentication() ? [
                'two_factor_confirmed_at',
            ] : []));
        });
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('assistance_requests_workshop');
        Schema::dropIfExists('assistance_requests');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('technicians');
        Schema::dropIfExists('workshops');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('rols');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('users');
    }
};
