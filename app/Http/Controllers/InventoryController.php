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
     * Función para visualizar registros en el inventario
     * Entradas:
     * - Valor de búsqueda: Cualquier palabra o número introducido
     * - Tipo de orden: Nombre del producto, Marca, Categoría, Precio, Cantidad, Descripción
     * - Dirección de orden: Ascendente, Descendente
     * Salidas: Registros filtrados según los valores de entrada
     */
    public function index(Request $request): View
    {
        // Obtención de valores para filtrar búsqueda
        $filter = $request->input('filter');
        $search = $request->input('search');
        
        // Llamado de función para ordenar registros
        $orderBy = $this->validateOrderByField($request->input('order_by', 'inventories.fk_idProduct'));
        
        // Ordenar la dirección de registros
        $orderDirection = $request->input('order_direction', 'asc');
        
        // Llamado a la función para obtener productos no registrados en el inventario
        $products = $this->getProductsNotInInventory();
        
        // Llamado a la función para filtrar registros
        $inventories = $this->getFilteredInventories($search, $filter, $orderBy, $orderDirection);
        
        // Llamado a la función para validar consulta y obtener mensaje si es necesario
        $message_empty = $this->validateRows($inventories, $search);
    
        // Redireccionar a la vista con los registros
        return view('inventory.index', compact('products', 'inventories', 'filter', 'message_empty'));
    }
    
    /**
     * Función para validar si hay registros
     * Entradas: Registros de inventario | Valor de búsqueda
     * Salidas: Mensaje de error
     */
    private function validateRows($inventories, $search): ?string
    {
        // Validación si no hay registros en la consulta de inventarios
        if ($inventories->isEmpty()) {
            if ($search) {
                // Mensaje cuando no hay registros con el término de búsqueda
                return __('There are no records with the term "' . $search . '"');
            } else {
                // Mensaje cuando no hay registros en general
                return __('There are no records to show');
            }
        }
        return null; // Retornar null si hay registros
    }
    /**
     * Función para validar el orden mediante el campo
     * Entradas: El tipo de rodenamiento (Producto, ID inventario, ID Producto)
     * Salidas: Tipo de ordenamiento
     */
    private function validateOrderByField(?string $orderBy): string
    {
        // Arreglo con posibles ordenamientos
        $validOrderByFields = [
            'inventories.id',
            'inventories.fk_idProduct',
            'product.name_product',
        ];

        // Retornar en un arreglo el tipo de orden | por defecto el ID del producto
        return in_array($orderBy, $validOrderByFields) ? $orderBy : 'inventories.fk_idProduct';
    }
    
    /**
     * Función para validar los productos que no estan en el inventario (con todos los tipos)
     * Entradas: Ninguna
     * Salidas: Registros de productos que no tienen los cuatro tipos de comportamiento
     */
    private function getProductsNotInInventory()
    {
        // Retornar los productos que no tengan los cuatro comportamientos
        return Product::whereNotIn('id', function ($query) {
            $query->select('fk_idProduct')
                ->from('inventories')
                ->whereIn('type', ['buy', 'sale', 'devolution', 'waste'])
                ->groupBy('fk_idProduct')
                ->havingRaw('COUNT(DISTINCT type) = 4');
        })->get();
    }
    
    /**
     * Función para obtener registros del inventario filtrados
     * Entradas: Datos recibidos [
     * - Valor de búsqueda
     * - Filtro (Tipo de Entrada o Salida)
     * - Ordenamiento (Ordenar por... y Dirección de orden)
     * ]
     * Salidas: Registros del inventario
     */
    private function getFilteredInventories(?string $search, ?string $filter, string $orderBy, string $orderDirection)
    {
        // Preparar la consulta para obtener el inventario y los productos
        $inventories = Inventory::join('products as product', 'inventories.fk_idProduct', '=', 'product.id')
            ->select(
                'inventories.id',
                'inventories.type',
                'inventories.fk_idProduct',
                'product.name_product',
                'product.image'
            )->when($search, function ($query) use ($search) {
                $this->applySearchFilter($query, $search); // Aplicar el filtro de búsqueda
            })->when($filter, function ($query) use ($filter) {
                $this->applyTypeFilter($query, $filter); // Aplicar el filtro de tipo (E/S)
            })->orderBy($orderBy, $orderDirection)->paginate(10); // Orden, Dirección y Paginación

        // Retornar registros de inventario
        return $inventories;
    }
    
    /**
     * Función para aplicar el filtro de búsqueda (valor en la barra de búsqueda)
     * Entrada: [
     * - Consulta preparada de los registros
     * - Valor de búsqueda
     * ]
     * Salidas: Registros filtrados mediante el valor 
     */
    private function applySearchFilter($query, string $search)
    {
        // Aplicar consulta mediante el filtro de búsqueda $search
        $query->where(function ($query) use ($search) {
            $query->where('inventories.id', 'LIKE', '%' . $search . '%')
                ->orWhere('inventories.type', 'LIKE', '%' . $search . '%')
                ->orWhere('inventories.fk_idProduct', 'LIKE', '%' . $search . '%')
                ->orWhere('product.name_product', 'LIKE', '%' . $search . '%');
        });
    }
    
    /**
     * Función para aplicar el tipo de filtro (Entradas o Salidas)
     * Entradas: [
     * - Consulta de registros
     * - Filtro de tipo (Entradas, SaLidas, Compras, Ventas, Desechos, Devoluciones)
     * ]
     * Salidas: Registros filtrados
     */
    private function applyTypeFilter($query, string $filter)
    {
        // Creación de arreglo con el tipo de E/S
        $filterMap = [
            'receipts' => ['buy', 'devolution'],
            'shipments' => ['sale', 'waste'],
            'buys' => ['buy'],
            'sales' => ['sale'],
            'devolutions' => ['devolution'],
            'wastes' => ['waste']
        ];

        // Aplicar el filtro si existe
        if (isset($filterMap[$filter])) {
            $query->whereIn('inventories.type', $filterMap[$filter]);
        }
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