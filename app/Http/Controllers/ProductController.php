<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    /**
     * Función para visualizar registros de productos
     * Entradas:
     * - Valor de búsqueda: Cualquier palabra o número introducido
     * - Tipo de orden: Nombre del producto, Marca, Categoría, Precio, Cantidad, Descripción
     * - Dirección de orden: Ascendente, Descendente
     * Salidas: Registros filtrados según los valores de entrada
     */
    public function index(Request $request): View
    {
        // Se obtienen los valores de búsqueda (si existen)
        $search = $request->input('search'); // Valor
        $orderBy = $request->input('order_by'); // Orden
        $orderDirection = $request->input('order_direction', 'asc'); //Dirección
        
        // Se crea una consulta según el valor recibido
        $products = Product::when($search, function($query, $search) {
            $query->where('name_product', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%")
                  ->orWhere('stock', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        });
        // Se ordenan los registros
        if ($orderBy) {
            $products->orderBy($orderBy, $orderDirection);
        }
        // Se activa la paginación de los registros
        $products = $products->paginate(10);
        // Validación si no hay registros con el valor de búsqueda
        if($products->isEmpty()){
            $message_empty = __('There are no records with the term "'.$search.'"');
            return view('product.index', compact('message_empty', 'products'));
        }
        // Se muestra la vista
        return view('product.index', compact('products'));
    }

    /**
     * Función para almacenar nuevo registro de producto
     * Entradas: Datos del nuevo producto [
     * - Nombre
     * - Marca
     * - Categoría
     * - Precio
     * - Cantidad
     * - Descripción
     * - Imagen
     * ]
     * Salidas: [
     * - Mensajes de error: Valores no permitidos en las entradas
     * - Mensajes éxitosos: Redirección al index con mensaje de registro
     * ]
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        // Se realiza la validación de los datos recibidos
        $data = $request->validated();
        // Se realiza el guardado de imagen
        $imageName = $this->imageUpload($request);
        // Se registra el nuevo producto
        Product::create([
            'name_product' => $data['name_product'],
            'brand' => $data['brand'],
            'category' => $data['category'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'],
            'image' => $imageName,
        ]);
        // Se redirecciona a la ruta de todos los registros de productos
        return Redirect::route('product.index')
            ->with('store', 'store');
    }

    /**
     * Función para guardar imagen
     * Entradas: Información del producto
     * Salidas: Nombre del archivo
     */
    private function imageUpload($request)
    {
        // Validación si el campo 'image' contiene un archivo
        if ($request->hasFile('image')) {
            // Se obtiene el archivo
            $file = $request->file('image');
            // Se valida si el archivo es valido
            if ($file->isValid()) {
                /**
                 *  Nomenclatura para guardar archivos:
                 * 'pd' = Abreviación para producto
                 * 'dmYHis' = Día Mes Año (Formato DD/MM/YYYY), Hora Minuto Segundo (Formato 24hrs. 00:00:00)
                 * '.png' = Extensión para la imagen final
                 */
                $imageName = 'pd-' . date('dmYHis') . '.png';
                // Mover imagen a la ruta indicada
                $file->move(public_path('uploads/product/'), $imageName);
                // Retornar el nombre de la imagen
                return $imageName;
            }
        }
        // Retornar NULL por defecto
        return null;
    }
    /**
     * Función para mostrar detalles de un solo producto
     * Entradas: ID del producto
     * Salidas: Información completa del producto
     */
    public function show($id): View
    {
        // Se busca y obtiene la información del producto
        $product = Product::find($id);
        // Se redirecciona a la vista con el producto
        return view('product.show', compact('product'));
    }

    /**
     * Función para mostrar el formulario de edición de producto
     * Entradas: ID del producto
     * Salidas: Vista con el objeto del producto
     */
    public function edit($id): View
    {
        // Se busca el producto
        $product = Product::find($id);
        // Se muestra la vista con el producto
        return view('product.form', compact('product'));
    }

    /**
     * Función para actualizar producto
     * Entradas: ID del producto, Datos recibidos[
     * - Nombre
     * - Marca
     * - Categoría
     * - Precio
     * - Stock
     * - Descripción
     * - Imagen
     * ]
     */
    public function update(ProductRequest $request, $id): RedirectResponse
    {
        // Se validan los datos recibidos
        $data = $request->validated();
        // Se encuentra en producto con el ID recibido
        $product = Product::find($id);
        // Se evalua el comportamiento de la imagen
        $image = $this->validateImage($request, $product);
        // Combina los datos del formulario con la imagen procesada
        $data = array_merge($data, ['image' => $image]);
        // Actualiza el registro
        $product->update($data);
        // Redirección a los registros de productos
        return Redirect::route('product.index')
            ->with('update', 'update');
    }

    /**
     * Función para validar la imagen
     * Entradas: 
     * - Información del producto
     * Salida: 
     * - Retorno de nombre de la imagen
     * - Almacenamiento de nueva imagen (si existe)
     * - Eliminación de imagen almacenada 
     */
    public function validateImage($request, $product)
    {
        // Si hay una nueva imagen cargada
        if ($request->hasFile('image')) {
            // Elimina la imagen anterior si existe
            $this->removeImage($product->image);
            // Sube y retorna el nombre de la nueva imagen
            return $this->imageUpload($request);
        }
        // Si no hay nueva imagen pero se quiere eliminar la actual
        if (is_null($request->input('name_preview')) && !is_null($product->image)) {
            $this->removeImage($product->image);
            return null;
        }
        // Mantener la imagen actual si no se ha subido una nueva
        return $product->image;
    }

    /**
     * Función para remover imagen de "/uploads/product/..."
     * Entradas: Nombre de la imagen del producto
     * Salidas: Ninguna, solo eliminación de la imagen
     */
    public function removeImage($imageName)
    {
        // Se recupera la ruta de la imagen almacenada
        $filePath = public_path('uploads/product/' . $imageName);
        // Si la ruta existe, elimina la imagen
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        // Retornar NULL por defecto
        return null;
    }

    /**
     * Función para eliminar registro
     * Entradas: ID del producto
     * Salidas: Redireccionamiento al index con mensaje de eliminación
     */
    public function destroy($id): RedirectResponse
    {
        // Se busca el registro por el ID
        $product = Product::find($id);
        // Se elimina la imagen si existe
        if($product->image != NULL){
            $this->removeImage($product->image);
        }
        // Se elimina el registro
        $product->delete();
        // Redirección a la ruta de registros de productos
        return Redirect::route('product.index')
            ->with('delete', 'delete');
    }
}