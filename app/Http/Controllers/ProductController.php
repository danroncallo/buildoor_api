<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('stocks')->with('images')->get();
        return response()->json(['products' => $products]);
    }

    public function indexForStore()
    {
        $products = Product::where('status', 'activo')->with('stocks')->with('images')->get();
        return response()->json(['products' => $products]);
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->tax = $request->tax;
        $product->save();
        $product->categories()->sync($request->categories);
        $product->uses()->sync($request->uses);

        $default_image = Image::findOrFail(1);
        $image = new Image();
        $image->original_name = $default_image->original_name;
        $image->path = $default_image->path;
        $image->full_path = $default_image->full_path;
        $image->main_image = true;
        $image->default_image = true;
        $image->product_id = $product->id;
        $image->save();

        $stock = new Stock();
        $stock->quantity = 0;
        $stock->product_id = $product->id;
        $stock->save();
//        
//        if($request->hasFile('image')){
//            return response()->json(['success'=>'i got image']);
//        }
//
//        if($request->hasFile('image'))
//        {
//            $image = new Image();
//            $image->image_path = $this->uploadImage($request->image);
//            $image->product_id = 1;
//            $image->save();
//        }

//        if ($request->hasFile('photo')) {
//            $file = $request->photo;
//            $path = $request->photo->store('images');
//            return response()->json(['success'=>true]);
//        }

        return response()->json(['success' => true, 'product' => $product->id]);
    }

    public function show(Product $product)
    {
        $image = Image::select('path')->where('product_id', $product->id)->first();

        return response()->json(['product' => $product,
            'images' => $product->images,
            'stocks' => $product->stocks,
            'categories' => $product->categories,
            'uses' => $product->uses]);
    }

    public function update(Request $request, Product $product)
    {
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->tax = $request->tax;
        $product->categories()->sync($request->categories);
        $product->uses()->sync($request->uses);

        return response()->json(['success' => $product->update()]);
    }

    public function destroy(Product $product)
    {
        $product->categories()->detach();
        $product->uses()->detach();
        return response()->json(['success' => $product->delete()]);
    }

    public function updateStatus(Product $product)
    {
        if ($product->status=='activo')
            $product->status = 'inactivo';

        else if ($product->status=='inactivo')
            $product->status = 'activo';

        $product->update();

        return response()->json(['success' => true,
            'message' => 'product status updated']);
    }

    public function productCategoriesAndUses(Product $product)
    {
        return response()->json(['product' => $product,
            'categories' => $product->categories,
            'uses' => $product->uses]);
    }

    public function storeProductImages(Request $request, Product $product)
    {
//        return response()->json(['r' => $request->all().length()]);
//        foreach ($request->all() as $image) {
//            return response()->json(['r' => is_file($image)]);
//        }

        foreach ($request->all() as $image) {

            $defaultImage = Image::where('product_id', $product->id)
                ->where('main_image', '=', 1)
                ->where('default_image', '=', 1)
                ->first();

//            if ($request->hasFile('image')) {
            if (is_file($image)) {
                if ($defaultImage) {
                    $defaultImage->delete();
                }

                $base_path = 'images/products';
                $server_path = 'http://' . $_SERVER['HTTP_HOST'] . '/';
                $file = $image;

                $filename = date('Y-m-d-h-i-s') . "."
                    . sha1($file->getClientOriginalName()) . "."
                    . $file->getClientOriginalExtension();

                $file->move($base_path, $filename);

                $image = new Image();
                $image->original_name = $file->getClientOriginalName();
                $image->path = $base_path . "/" . $filename;
                $image->full_path = $server_path . $base_path . "/" . $filename;
                $image->product_id = $product->id;
                $image->default_image = false;

                $mainImage = Image::where('product_id', $product->id)
                    ->where('main_image', true)
                    ->first();

                if (!$mainImage) {
                    $image->main_image = true;
                }

                $image->save();

            }
        }
        return response()->json(['success' => true]);
    }

    public function deleteProductImages(Request $request, Image $image)
    {
        $filename= $image->full_path;
        $image->delete();
        File::delete($filename);
        return response()->json(['success' => true,
                                'message' => 'file was deleted']);
    }

    public function searchKeyword($keyword)
    {
        $products_search = DB::table('products AS p')
            ->select('p.id')
            ->where('p.name', 'like', '%' . $keyword . '%')
            ->orWhere('p.description', 'like', '%' . $keyword . '%')
            ->get();

        $categories_search = DB::table('products AS p')
            ->join('category_product AS cp', 'cp.product_id', '=', 'p.id')
            ->join('categories AS c', 'c.id', '=', 'cp.category_id')
            ->select('p.id')
            ->where('c.name', 'like', '%' . $keyword . '%')
            ->get();

        $uses_search = DB::table('products AS p')
            ->join('product_use AS pu', 'pu.product_id', '=', 'p.id')
            ->join('uses AS u', 'u.id', '=', 'pu.use_id')
            ->select('p.id')
            ->where('u.name', 'like', '%' . $keyword . '%')
            ->get();

        $mergeSearch = array_merge($products_search->toArray(),
            $categories_search->toArray(),
            $uses_search->toArray());

        $products = array_values(array_unique($mergeSearch, SORT_REGULAR));

        $products_ids = [];
        foreach ($products as $key => $value) {
            foreach ($value as $k => $v) {
                array_push($products_ids, $v);
            }
        }

        $products = Product::whereIn('id', $products_ids)
            ->where('status', 'activo')
            ->with('stocks')
            ->with('images')
            ->get();

        return response()->json(['products' => $products]);
    }

    public function searchByPriceRange($min, $max)
    {
        $products = Product::whereBetween('price', [$min, $max])
            ->where('status', 'activo')
            ->with('stocks')
            ->with('images')
            ->get();

        return response()->json(['products' => $products]);
    }
}
