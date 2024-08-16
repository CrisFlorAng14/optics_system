<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $inventories = Inventory::paginate();

        return view('inventory.index', compact('inventories'))
            ->with('i', ($request->input('page', 1) - 1) * $inventories->perPage());
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
        Inventory::create($request->validated());

        return Redirect::route('inventories.index')
            ->with('success', 'Inventory created successfully.');
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
