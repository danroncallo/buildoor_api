<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use App\Product;
use App\ShoppingCart;
use App\Stock;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function confirmation(Request $request)
    {
        $reference_code = $request->reference_sale;
//
//        $order = Order::where('referenceCode', $referenceCode)->first();
//        $order->total = $request->value;
//        $order->tax = $request->tax;
//        $order->date = $request->transaction_date;
//        $order->status = "complete";
//        $order->update();

        $transaction = new Transaction();
//        $transaction->order_id = $order->id;
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

        $order = Order::where('reference_code', $reference_code)->first();
        $order->total = $transaction->value;
        $order->tax = $transaction->tax;
        $order->date = $transaction->transaction_date;
        if ($transaction->state_pol == 4){
            $order->status = "approved";
        }
        else if ($transaction->state_pol == 6){
            $order->status = "declined";
        }
        $order->update();

        $transaction->order_id = $order->id;
        $transaction->update();

        $user = $order->user;

        $shopping_cart_items = ShoppingCart::where('user_id', $user->id)->get();

        //resta de stock
        foreach ($shopping_cart_items as $item) {
            $stock = Stock::findOrFail($item->stock_id);
            $stock->quantity -= $item->quantity;
            $stock->update();

            $product = Product::findOrFail($stock->product->id);

            $detail = new OrderDetail();
            $detail->product_name = $product->name;
            $detail->product_description = $product->description;
            $detail->product_price = $product->price;
            $detail->product_id = $product->id;
            $detail->product_tax = $product->tax;

            $detail->product_quantity = $item->quantity;

            $detail->product_total = ($item->quantity * $product->price);
            $detail->order_id = $order->id;
            $detail->save();
        }

        ShoppingCart::where('user_id', $user->id)->delete();
    }

//    public function updateOrder()
//    {
//        $transaction = Transaction::findOrFail(11);
//        $order = Order::where('reference_code', $transaction->reference_sale)->first();
//        return response()->json(['' => $order]);
//
////
////            return response()->json(['' => $shopping_cart_id_items]);
////
////            $stocks_id_items = ShoppingCart::where('user_id', $user->id)
////                ->pluck('stock_id')
////                ->toArray();
//
////            $stocks = Stock::whereIn('id', $stocks_id_items)->get();
////
////            return response()->json(['' => $stocks]);
////
////            foreach ($stocks_id_items as $stock_id){
////                $product = Product::where('id', $stock_id)->first();
////
////            }
////        dd($items);
////}
////                        ->get();
////
////        ->whereHas('orders', function($q) use ($referenceCode){
//////                $q->where('referenceCode', $referenceCode);
//////            })->first()
//////            ->first();
//
////            return $items;
////            return response()->json(['items' =>$items]);
//
//
//
//    }
//}

}
