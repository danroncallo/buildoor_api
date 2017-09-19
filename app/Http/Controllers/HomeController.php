<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = 100;
        $merchantId = 508029;
//        $merchantId = 638625;
//        $accountId = 640990;
        $accountId = 512321;
        $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
//        $apiKey = "s3sP52hlBjKQ6mt4E945E3P9sO";
        $referenceCode = str_random(10);
        $currency = "COP";
        $buyerEmail = "eliojavier86@gmail.com";
        $signature = sha1($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $amount . "~" . $currency);
        return view('home', compact('amount', 'merchantId', 'apiKey', 'referenceCode',
            'currency', 'buyerEmail', 'signature', 'accountId'));
    }

    public function response(Request $request)
    {
        dd($request);
    }

    public function confirmation(Request $request)
    {
        $transaction = new Transaction();

        $transaction->merchant_id = $request->merchant_id;
        $transaction->state_pol = $request->state_pol;
        $transaction->risk = $request->risk;
        $transaction->response_code_pol = $request->response_code_pol;
        $transaction->reference_sale = $request->reference_sale;
        $transaction->reference_pol = $request->reference_pol;
        $transaction->sign = $request->sign;
        $transaction->extra1 = $request->extra1;
        $transaction->extra2 = $request->extra2;
        $transaction->payment_method = $request->payment_method;
        $transaction->payment_method_type = $request->payment_method_type;
        $transaction->installments_number = $request->installments_number;
        $transaction->value = $request->value;
        $transaction->tax = $request->tax;
        $transaction->additional_value = $request->additional_value;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->currency = $request->currency;
        $transaction->email_buyer = $request->email_buyer;
        $transaction->cus = $request->cus;
        $transaction->pse_bank = $request->pse_bank;
        $transaction->test = $request->test;
        $transaction->description = $request->description;
        $transaction->billing_address = $request->billing_address;
        $transaction->shipping_address = $request->shipping_address;
        $transaction->phone = $request->phone;
        $transaction->office_phone = $request->office_phone;
        $transaction->account_number_ach = $request->account_number_ach;
        $transaction->account_type_ach = $request->account_type_ach;
        $transaction->administrative_fee = $request->administrative_fee;
        $transaction->administrative_fee_base = $request->administrative_fee_base;
        $transaction->administrative_fee_tax = $request->administrative_fee_tax;
        $transaction->airline_code = $request->airline_code;
        $transaction->attempts = $request->attempts;
        $transaction->authorization_code = $request->authorization_code;
        $transaction->bank_id = $request->bank_id;
        $transaction->billing_city = $request->billing_city;
        $transaction->billing_country = $request->billing_country;
        $transaction->commision_pol = $request->commision_pol;
        $transaction->commision_pol_currency = $request->commision_pol_currency;
        $transaction->customer_number = $request->customer_number;
        $transaction->date = $request->date;
        $transaction->error_code_bank = $request->error_code_bank;
        $transaction->error_message_bank = $request->error_message_bank;
        $transaction->exchange_rate = $request->exchange_rate;
        $transaction->ip = $request->ip;
        $transaction->nickname_buyer = $request->nickname_buyer;
        $transaction->nickname_seller = $request->nickname_seller;
        $transaction->payment_method_id = $request->payment_method_id;
        $transaction->payment_request_state = $request->payment_request_state;
        $transaction->pseReference1 = $request->pseReference1;
        $transaction->pseReference2 = $request->pseReference2;
        $transaction->pseReference3 = $request->pseReference3;
        $transaction->response_message_pol = $request->response_message_pol;
        $transaction->shipping_city = $request->shipping_city;
        $transaction->shipping_country = $request->shipping_country;
        $transaction->transaction_bank_id = $request->transaction_bank_id;
        $transaction->transaction_id = $request->transaction_id;
        $transaction->payment_method_name = $request->payment_method_name;

        $transaction->save();
    }
}
