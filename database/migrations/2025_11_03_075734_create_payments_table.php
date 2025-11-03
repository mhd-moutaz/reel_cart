<?php

use App\Enums\PaymentMethodEnum;
use App\Enums\StatusPaymentEnum;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', [PaymentMethodEnum::CreditCard, PaymentMethodEnum::PayPal, PaymentMethodEnum::BankTransfer]);
            $table->enum('status', [StatusPaymentEnum::Pending,StatusPaymentEnum::Completed, StatusPaymentEnum::Failed])->default(StatusPaymentEnum::Pending);
            $table->text('transaction_reference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};


