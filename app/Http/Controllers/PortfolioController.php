<?php

namespace App\Http\Controllers;

use App\Image;
use App\Portfolio;
use App\User;
use Illuminate\Http\Request;

class PortfolioController extends Controller
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
        $portfolios = Portfolio::where('user_id', $user->id)
                                ->with('images')
                                ->get();
//        return response()->json(['portfolios' => $user->portfolios,
//                                'images' => $user->portfolios->images]);
        return response()->json(['portfolios' => $portfolios]);
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
        $user = User::findOrFail($request->user()->id);
        
        $portfolio = new Portfolio();
        $portfolio->name = $request->name;
        $portfolio->description = $request->description;
        $portfolio->user_id = $user->id;
        
        return response()->json(['success' => $portfolio->save(), 'portfolio' => $portfolio->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Portfolio $portfolio)
    {
        $user = User::findOrFail($request->user()->id);

        if($user->id == $portfolio->user_id){
            return response()->json(['work' => $portfolio, 'images'=>$portfolio->images]);
        }

        return response()->json(['error' => 'Acceso denegado'])
            ->setStatusCode(400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $user = User::findOrFail($request->user()->id);

        if($user->id == $portfolio->user_id){
            $portfolio->name = $request->name;
            $portfolio->description = $request->description;

            return response()->json(['success' => $portfolio->update()]);
        }

        return response()->json(['error' => 'Acceso denegado'])
                                ->setStatusCode(400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Portfolio $portfolio)
    {
        $user = User::findOrFail($request->user()->id);

        if($user->id == $portfolio->user_id) {
            return response()->json(['success' => $portfolio->delete()]);
        }

        return response()->json(['error' => 'Acceso denegado'])
            ->setStatusCode(400);
    }

    public function storePortfoliosImages(Request $request, Portfolio $portfolio)
    {
        $user = User::findOrFail($request->user()->id);

        if ($portfolio->user_id = $user->id){
            if ($request->hasFile('image')) {
                $base_path = 'images/portfolios';
                $server_path = 'http://' . $_SERVER['HTTP_HOST'] . '/';
                $file = $request->image;

                $filename = date('Y-m-d-h-i-s') . "."
                    . sha1($file->getClientOriginalName()) . "."
                    . $file->getClientOriginalExtension();

                $file->move($base_path, $filename);

                $image = new Image();
                $image->original_name = $file->getClientOriginalName();
                $image->path = $base_path . "/" . $filename;
                $image->full_path = $server_path.$base_path . "/" . $filename;
                $image->portfolio_id = $portfolio->id;
                $image->default_image = false;
                $image->save();

                return response()->json(['success' => $image->save()]);
            }
        }

        return response()->json(['success' => false]);
    }
}
