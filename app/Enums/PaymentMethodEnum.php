<?php
namespace App\Enums;
enum PaymentMethodEnum: string
{
    case CreditCard = 'credit_card';
    case PayPal = 'paypal';
    case BankTransfer = 'bank_transfer';
}
