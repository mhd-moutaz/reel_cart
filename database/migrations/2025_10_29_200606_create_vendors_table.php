<?php

use App\Enums\HasStoreVendorEnum;
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
            $table->text('description')->nullable();
            $table->enum(
                'verification_status',
                [
                    VerificationStatusVendorEnum::Pending,
                    VerificationStatusVendorEnum::Verified,
                    VerificationStatusVendorEnum::Rejected
                ]
            )->default(VerificationStatusVendorEnum::Pending);
            $table->enum(
                'has_store',
                [HasStoreVendorEnum::online, HasStoreVendorEnum::onSite]
            );
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
