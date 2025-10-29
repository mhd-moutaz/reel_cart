<?php

use App\Enums\VerificationStatusVendorEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('national_id')->unique();
            $table->string('business_type');
            $table->text('description');
            $table->enum('verification_status', [
                VerificationStatusVendorEnum::Pending,
                VerificationStatusVendorEnum::Verified,
                VerificationStatusVendorEnum::Rejected ]
            )->default(VerificationStatusVendorEnum::Pending);
            $table->string('has_store');
            $table->text('pickup_address');
            $table->time('pickup_hours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};

