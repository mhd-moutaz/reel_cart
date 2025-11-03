<?php

use App\Enums\StatusOrderEnum;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('delivery_id')->nullable()->default(null)->constrained('deliveries');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', [
                StatusOrderEnum::Pending,
                StatusOrderEnum::Processing,
                StatusOrderEnum::Ready,
                StatusOrderEnum::Delivered,
                StatusOrderEnum::Completed,
                StatusOrderEnum::Cancelled
            ])->default(StatusOrderEnum::Pending);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
