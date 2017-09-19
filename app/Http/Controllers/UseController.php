<?php

namespace App\Http\Controllers;

use App\ProductUse;
use Illuminate\Http\Request;

class UseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uses = ProductUse::all();
        return response()->json(['uses'=>$uses]);
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
        $use = new ProductUse();

        $use->name = $request->name;
        $use->save();
       
        return response()->json([$use->save()]);
    }

    /**
     * Display the specified resource.
     *
     * @param ProductUse $use
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(ProductUse $use)
    {
        return response()->json(['use'=>$use]);
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
     * @param ProductUse $use
     * @return \Illuminate\Http\Response
     * @internal param Category $category
     * @internal param int $id
     */
    public function update(Request $request, ProductUse $use)
    {
        $use->name = $request->name;

        return response()->json(['success'=>$use->update()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductUse $use
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @internal param int $id
     */
    public function destroy(ProductUse $use)
    {
        return response()->json(['success'=>$use->delete()]);
    }

    /**
     * Display products of specified use.
     *
     * @param ProductUse $use
     * @return \Illuminate\Http\JsonResponse
     * @internal param ProductUse $productUse
     * @internal param Category $category
     */
    public function useProducts(ProductUse $use)
    {
        return response()->json(['products'=>$use->activeProducts]);
    }
}
