<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('state_pol')->nullable();
            $table->string('risk')->nullable();
            $table->string('response_code_pol')->nullable();
            $table->string('reference_sale')->nullable();
            $table->string('reference_pol')->nullable();
            $table->string('sign')->nullable();
            $table->string('extra1')->nullable();
            $table->string('extra2')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_method_type')->nullable();
            $table->string('installments_number')->nullable();
            $table->decimal('value', 14, 2)->nullable();
            $table->decimal('tax', 14, 2)->nullable();
            $table->string('additional_value')->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('currency')->nullable();
            $table->string('email_buyer')->nullable();
            $table->string('cus')->nullable();
            $table->string('pse_bank')->nullable();
            $table->string('test')->nullable();
            $table->string('description')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('account_number_ach')->nullable();
            $table->string('account_type_ach')->nullable();
            $table->string('administrative_fee')->nullable();
            $table->string('administrative_fee_base')->nullable();
            $table->string('administrative_fee_tax')->nullable();
            $table->string('airline_code')->nullable();
            $table->string('attempts')->nullable();
            $table->string('authorization_code')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('commision_pol')->nullable();
            $table->string('commision_pol_currency')->nullable();
            $table->string('customer_number')->nullable();
            $table->string('date')->nullable();
            $table->string('error_code_bank')->nullable();
            $table->string('error_message_bank')->nullable();
            $table->string('exchange_rate')->nullable();
            $table->string('ip')->nullable();
            $table->string('nickname_buyer')->nullable();
            $table->string('nickname_seller')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->string('payment_request_state')->nullable();
            $table->string('pseReference1')->nullable();
            $table->string('pseReference2')->nullable();
            $table->string('pseReference3')->nullable();
            $table->string('response_message_pol')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('transaction_bank_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_method_name')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                            ->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
