<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\DB;
use App\Models\Product;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filter = $request->input('filter');
        $search = $request->input('search');
    
        $products = Product::all(); // Obtén todos los productos si es necesario
    
        $inventories = Inventory::join('products as product', 'inventories.fk_idProduct', '=', 'product.id')
            ->select(
                'inventories.id',
                'inventories.type',
                'inventories.fk_idProduct',
                'product.name_product',
                'product.image'
            )->latest('inventories.id');
    
        if ($search) {
            $inventories->where('inventories.id', 'LIKE', '%' . $search . '%')
                ->orWhere('inventories.type', 'LIKE', '%' . $search . '%')
                ->orWhere('inventories.fk_idProduct', 'LIKE', '%' . $search . '%')
                ->orWhere('product.name_product', 'LIKE', '%' . $search . '%');
        }
    
        if ($filter) {
            $filterMap = [
                'Entradas' => ['Compra', 'Devolución'],
                'Salidas' => ['Venta', 'Desecho'],
                'Compras' => ['Compra'],
                'Ventas' => ['Venta'],
                'Devoluciones' => ['Devolución'],
                'Desechos' => ['Desecho']
            ];
            
            if (isset($filterMap[$filter])) {
                $inventories->whereIn('inventories.type', $filterMap[$filter]);
            }
        }
    
        $inventories = $inventories->paginate(10);
    
        return view('inventory.index', compact('products', 'inventories', 'filter'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $inventory = new Inventory();

        return view('inventory.create', compact('inventory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryRequest $request): RedirectResponse
    {
        $request->validated();

        $type = $request->input('type');
        $idProduct = $request->input('fk_idProduct');

        $repeatRow = DB::table('inventories')
            ->where('fk_idProduct', $idProduct)
            ->where('type', $type)
            ->exists();

        if($repeatRow){
            return Redirect::route('inventory.index')
                ->with('exists','exists');   
        }
        
        Inventory::create([
            'type' => $type,
            'fk_idProduct' => $idProduct,
        ]);


        return Redirect::route('inventory.index')
            ->with('store', 'store');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $inventory = Inventory::find($id);

        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $inventory = Inventory::find($id);

        return view('inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryRequest $request, Inventory $inventory): RedirectResponse
    {
        $inventory->update($request->validated());

        return Redirect::route('inventories.index')
            ->with('success', 'Inventory updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Inventory::find($id)->delete();

        return Redirect::route('inventories.index')
            ->with('success', 'Inventory deleted successfully');
    }
}
