<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $products = Product::paginate();

        return view('product.index', compact('products'))
            ->with('i', ($request->input('page', 1) - 1) * $products->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $product = new Product();

        return view('product.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $imageName = $this->imageUpload($request);
        Product::create([
            'name_product' => $data['name_product'],
            'brand' => $data['brand'],
            'category' => $data['category'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'],
            'image' => $imageName,
        ]);

        return Redirect::route('product.index')
            ->with('store', 'store');
    }

    private function imageUpload($request) {
        if($request->hasFile('image')){
            $file = $request->file('image');

            if($file->isValid()){
                $imageName = date('YmdHis').'.png';
                $file->move('uplaods/product/',$imageName);
                return $imageName;
            }
        }
        return null;
    }
    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $product = Product::find($id);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $product = Product::find($id);

        return view('product.form', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return Redirect::route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Product::find($id)->delete();

        return Redirect::route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
