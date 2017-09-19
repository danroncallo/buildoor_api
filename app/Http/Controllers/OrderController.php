<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        $orders = Order::select('id', 'reference_code', 'total', 'date')
                            ->where('user_id', $user->id)
                            ->where('status', 'approved')
                            ->orderBy('updated_at', 'DESC')
                            ->with(array('transaction' => function($q) {
                                $q->select('currency', 'reference_pol', 'order_id');
                            }))
                            ->get();
//
//        User::with(array('post'=>function($query){
//            $query->select('id','user_id');
//        }))->get();

        return response()->json(['orders' => $orders]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderDetails(Request $request, $id)
    {
        $user = User::findOrFail($request->user()->id);
        $order = Order::findOrFail($id);
//                        ->with(array('orderDetails' => function($q) {
//                                $q->select('product_name', 'product_description', 'product_price', 'order_id');
//                        }))->get();

        if ($order->user_id == $user->id){
            return response()->json(['details' => $order->orderDetails]);
        }

        return response()->json(['success' => false,
                                'msg' => 'invalid credentials'])
                            ->setStatusCode(400);
    }

    public function placeOrder(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        $referenceCode = mt_rand(100000000, 999999999);
        $orderExists = Order::where('reference_code', $referenceCode)->first();
        if ($orderExists) {
            while($orderExists){
                $referenceCode = mt_rand(1000000000, 9999999999);
                $orderExists = Order::where('reference_code', $referenceCode)->first();
            }
        }
        
        $order = new Order();
        $order->reference_code = $referenceCode;
        $order->user_id = $user->id;
        $order->save();
        if (!$order) {
            return response()->json(['success' => false,
                                    'msg' => 'Orden no pudo ser guardada'])
                                ->setStatusCode(500);
        }
//        $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
        $apiKey = "s3sP52hlBjKQ6mt4E945E3P9sO";
        $amount = number_format($request->amount, 2, '.', '');
//        $merchantId = 508029;
        $merchantId = 638625;
//        $accountId = 512321;
        $accountId = 640990;
        $description = 'Compra Buildoor';
        $tax = number_format($request->tax, 2, '.', '');
        $taxReturnBase = number_format($request->taxReturnBase, 2, '.', '');
        $currency = $request->currency;
        $signature = md5($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $amount . "~" . $currency);
        $test = 0;
        $buyerEmail = $user->email;
        $lng = "es";
        $extra1 = "";
        $extra2 = "";
        $responseUrl = "http://buildoorecommerce.azurewebsites.net/transactions";
        $confirmationUrl = "http://www.palmarius.com.ve/api/payu/confirmation";
        $payerFullName = "";
        $payerDocument = $user->identification;
        $mobilePhone = "";
        $billingAddress = "";
        $shippingAddress = "";
        $telephone = $user->phone;
        $officeTelephone = "";
        $algorithmSignature = 'MD5';
        $extra3 = "";
        $extra3 = "";
        $billingCity = "";
        $shippingCity = "";
        $zipCode = "";
        $billingCountry = "";
        $shippingCountry = "";
        $buyerFullName = "";
        $payerEmail = $user->email;
        $payerPhone = $user->phone;
        $payerOfficePhone = "";
        $payerMobilePhone = "";

        return response()->json(['amount' => number_format($amount, 2, '.', ''),
                                'merchantId' => $merchantId,
                                'referenceCode' => $referenceCode,
                                'accountId' => $accountId,
                                'description' => $description,
                                'tax' => number_format($tax, 2, '.', ''),
                                'taxReturnBase' => number_format($taxReturnBase, 2, '.', ''),
                                'signature' => $signature,
                                'currency' => $currency,
                                'test' => $test,
                                'buyerEmail' => $buyerEmail,
                                'lng' => $lng,
                                'extra1' => $extra1,
                                'extra2'=> $extra2,
                                'responseUrl'=> $responseUrl,
                                'confirmationUrl'=> $confirmationUrl,
                                'payerFullName'=> $payerFullName,
                                'payerDocument'=> $payerDocument,
                                'mobilePhone'=> $mobilePhone,
                                'billingAddress'=> $billingAddress,
                                'shippingAddress'=> $shippingAddress,
                                'telephone'=> $telephone,
                                'officeTelephone'=> $officeTelephone,
                                'algorithmSignature'=> $algorithmSignature,
                                'extra3'=> $extra3,
                                'billingCity'=> $billingCity,
                                'shippingCity'=> $shippingCity,
                                'zipCode'=> $zipCode,
                                'billingCountry'=> $billingCountry,
                                'shippingCountry'=> $shippingCountry,
                                'buyerFullName'=> $buyerFullName,
                                'payerEmail'=> $payerEmail,
                                'payerPhone'=> $payerPhone,
                                'payerOfficePhone'=> $payerOfficePhone,
                                'payerMobilePhone'=> $payerMobilePhone
        ]);

//        return view('orderForm', compact('amount',
//                                        'merchantId',
//                                        'referenceCode',
//                                        'accountId',
//                                        'description',
//                                        'tax',
//                                        'taxReturnBase',
//                                        'signature',
//                                        'currency',
//                                        'test',
//                                        'buyerEmail',
//                                        'lng',
//                                        'extra1',
//                                        'extra2',
//                                        'responseUrl',
//                                        'confirmationUrl',
//                                        'payerFullName',
//                                        'payerDocument',
//                                        'mobilePhone',
//                                        'billingAddress',
//                                        'shippingAddress',
//                                        'telephone',
//                                        'officeTelephone',
//                                        'algorithmSignature',
//                                        'extra3',
//                                        'billingCity',
//                                        'shippingCity',
//                                        'zipCode',
//                                        'billingCountry',
//                                        'shippingCountry',
//                                        'buyerFullName',
//                                        'payerEmail',
//                                        'payerPhone',
//                                        'payerOfficePhone',
//                                        'payerMobilePhone'
//                                    ));
    }
//
//    public function placeOrderTest()
//    {
//        $amount = 100;
//        $merchantId = 508029;
////        $merchantId = 638625;
////        $accountId = 640990;
//        $accountId = 512321;
//        $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
////        $apiKey = "s3sP52hlBjKQ6mt4E945E3P9sO";
//        $referenceCode = str_random(10);
//        $currency = "COP";
//        $buyerEmail = "eliojavier86@gmail.com";
//        $confirmationUrl = "http://www.palmarius.com.ve/api/payu/confirmation";
//        $signature = sha1($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $amount . "~" . $currency);
////
////        $client = new \Guzzle([
////            'timeout'  => 5.0,
////        ]);
//
//        $formData = [
////            'merchantId' => $merchantId,
////            'accountId' => $accountId,
////            'apiKey' => '4Vj8eK4rloUd272L48hsrarnUA',
////            'description' => 'TestPayU',
////            'referenceCode' => $referenceCode,
////            'amount' => $amount,
////            'tax' => 0,
////            'taxReturnBase' => 0,
////            'currency' => $currency,
////            'signature' => $signature,
////            'test' => '1',
////            'buyerEmail' => $buyerEmail,
////            'payerFullName' => "APPROVED",
////            'algorithmSignature' => "SHA",
////            'responseUrl' => $confirmationUrl,
////            'confirmationUrl' => $confirmationUrl
////        ];
//
//

//    public function placeOrder(Request $request)
//    {
//        $user = User::findOrFail($request->user()->id);
//
//        $referenceCode = mt_rand(1000000000, 9999999999);
//        $orderExists = Order::where('reference_code', $referenceCode)->first();
//        if ($orderExists) {
//            while($orderExists){
//                $referenceCode = mt_rand(1000000000, 9999999999);
//                $orderExists = Order::where('reference_code', $referenceCode)->first();
//            }
//        }
//
//        $order = new Order();
//        $order->reference_code = $referenceCode;
//        $order->user_id = $user->id;
//        $order->save();
//        if (!$order) {
//            return response()->json(['success' => false,
//                'msg' => 'Orden no pudo ser guardada'])
//                ->setStatusCode(500);
//        }
//        $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
//        $apiKey = "s3sP52hlBjKQ6mt4E945E3P9sO";
//        $amount = number_format($request->amount, 2, '.', '');
//        $merchantId = 508029;
//        $merchantId = 638625;
//        $accountId = 512321;
//        $accountId = 640990;
//        $description = 'Compra Buildoor';
//        $tax = number_format($request->tax, 2, '.', '');
//        $taxReturnBase = number_format($request->taxReturnBase, 2, '.', '');
//        $currency = $request->currency;
//        $signature = sha1($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $amount . "~" . $currency);
//        $test = 0;
//        $buyerEmail = $user->email;
//        $lng = "es";
//        $extra1 = "";
//        $extra2 = "";
//        $responseUrl = "http://buildoorecommerce.azurewebsites.net/transactions";
//        $confirmationUrl = "http://www.palmarius.com.ve/api/payu/confirmation";
//        $payerFullName = "";
//        $payerDocument = $user->identification;
//        $mobilePhone = "";
//        $billingAddress = "";
//        $shippingAddress = "";
//        $telephone = $user->phone;
//        $officeTelephone = "";
//        $algorithmSignature = 'SHA';
//        $extra3 = "";
//        $billingCity = "";
//        $shippingCity = "";
//        $zipCode = "";
//        $billingCountry = "";
//        $shippingCountry = "";
//        $buyerFullName = "";
//        $payerEmail = $user->email;
//        $payerPhone = $user->phone;
//        $payerOfficePhone = "";
//        $payerMobilePhone = "";
//
//        return response()->json(['amount' => $amount,
//            'merchantId' => $merchantId,
//            'referenceCode' => $referenceCode,
//            'accountId' => $accountId,
//            'description' => $description,
//            'tax' => $tax,
//            'taxReturnBase' => $taxReturnBase,
//            'signature' => $signature,
//            'currency' => $currency,
//            'test' => $test,
//            'buyerEmail' => $buyerEmail,
//            'lng' => $lng,
//            'extra1' => $extra1,
//            'extra2'=> $extra2,
//            'responseUrl'=> $responseUrl,
//            'confirmationUrl'=> $confirmationUrl,
//            'payerFullName'=> $payerFullName,
//            'payerDocument'=> $payerDocument,
//            'mobilePhone'=> $mobilePhone,
//            'billingAddress'=> $billingAddress,
//            'shippingAddress'=> $shippingAddress,
//            'telephone'=> $telephone,
//            'officeTelephone'=> $officeTelephone,
//            'algorithmSignature'=> $algorithmSignature,
//            'extra3'=> $extra3,
//            'billingCity'=> $billingCity,
//            'shippingCity'=> $shippingCity,
//            'zipCode'=> $zipCode,
//            'billingCountry'=> $billingCountry,
//            'shippingCountry'=> $shippingCountry,
//            'buyerFullName'=> $buyerFullName,
//            'payerEmail'=> $payerEmail,
//            'payerPhone'=> $payerPhone,
//            'payerOfficePhone'=> $payerOfficePhone,
//            'payerMobilePhone'=> $payerMobilePhone
//        ]);
//
////        return view('orderForm', compact('amount',
////                                        'merchantId',
////                                        'referenceCode',
////                                        'accountId',
////                                        'description',
////                                        'tax',
////                                        'taxReturnBase',
////                                        'signature',
////                                        'currency',
////                                        'test',
////                                        'buyerEmail',
////                                        'lng',
////                                        'extra1',
////                                        'extra2',
////                                        'responseUrl',
////                                        'confirmationUrl',
////                                        'payerFullName',
////                                        'payerDocument',
////                                        'mobilePhone',
////                                        'billingAddress',
////                                        'shippingAddress',
////                                        'telephone',
////                                        'officeTelephone',
////                                        'algorithmSignature',
////                                        'extra3',
////                                        'billingCity',
////                                        'shippingCity',
////                                        'zipCode',
////                                        'billingCountry',
////                                        'shippingCountry',
////                                        'buyerFullName',
////                                        'payerEmail',
////                                        'payerPhone',
////                                        'payerOfficePhone',
////                                        'payerMobilePhone'
////                                    ));
//    }

}

