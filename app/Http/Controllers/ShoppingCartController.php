<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use App\Stock;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
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
//        return response()->json(['' => $user]);
//        return response()->json(['user' => $user]);

        $cart = DB::table('shopping_carts AS sc')
            ->join('users', 'users.id', '=', 'sc.user_id')
            ->join('stocks', 'stocks.id', '=', 'sc.stock_id')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('images', 'images.product_id', '=', 'products.id')
//            ->select('sc.id AS id', 'sc.quantity AS quantity', 'products.name AS product',
//                'products.price AS unitary_price', DB::raw('sc.quantity * products.price AS total'))
                ->select('sc.id AS id', 'sc.quantity AS quantity', 'products.name AS product',
                        'products.price AS unitary_price', 'products.currency AS currency', 'products.tax as tax',
                        'stocks.quantity AS stock_quantity', 'images.full_path', 'users.id AS user_id')
            ->where('users.id', '=', $user->id)
            ->where('images.main_image', '=', true)
            ->get();
//
//        $cart = ShoppingCart::where('user_id', 1)->get();
//
//        foreach($cart as $s){
//            $stock = $s->stock;
////            foreach($s->stock as $p){
////                $product = $p->product;
////            }
//        }
//
//        foreach ($cart->stock as $p){
//            return $p;
//        }

        return response()->json(['cart' => $cart]);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->quantity <= 0) {
            return response()->json(['success' => false]);
        }
        $user = User::findOrFail($request->user()->id);

//        return response()->json(['' => $request->all()]);
//        $stock = Stock::findOrFail($request->stock_id);
//        if ($stock->quantity < $request->quantity) {
//            return response()->json(['error'=>'No existe la cantidad requerida en inventario'])
//                                ->setStatusCode(400);
//        }
//
//        if ($request->quantity <= 0) {
//            return response()->json(['error'=>'Cantidad debe ser mayor o igual a cero'])
//                                ->setStatusCode(400);
//        }
        
//        $user_id = 1;
        
        //busco el stock_id y veo si existe en la bd para ese usuario, si existe sumo las cantidades.
        //Si no existe creo el nuevo registro
        $cart_exists = ShoppingCart::where('stock_id', $request->stock_id)
                                    ->where('user_id', $user->id)
                                    ->first();
        if ($cart_exists) {
            $cart_exists->quantity += $request->quantity;
            return response()->json(['success' => $cart_exists->update()]);
        }


        $cart = new ShoppingCart();
        $cart->user_id = $user->id;
        $cart->stock_id = $request->stock_id;
        $cart->quantity = $request->quantity;

        return response()->json(['success' => $cart->save()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param ShoppingCart $cart
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, ShoppingCart $cart)
    {
//        $stock = $cart->stock;

//        if($request->quantity > $stock->quantity){
//            return response()->json(['success' => false,
//                                    'error' => 'cantidad no disponible'])
//                                ->setStatusCode(400);
//        }

        $cart->quantity = $request->quantity;
        return response()->json(['success' => $cart->update()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ShoppingCart $cart
     * @return \Illuminate\Http\Response
     * @internal param ShoppingCart $shoppingCart
     * @internal param ShoppingCart $item
     * @internal param int $id
     */
    public function destroy(ShoppingCart $cart)
    {
        return response()->json(['success' => $cart->delete()]);
    }

    public function emptyCart(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        return response()->json(['success' => ShoppingCart::where('user_id', $user->id)->delete()]);
    }
}
