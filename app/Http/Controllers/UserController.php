<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::paginate(10);
    
        // Transformar las fechas en cada usuario de la colección paginada
        $users->getCollection()->transform(function ($user) {
            $user->birthdate = $this->dateTransform($user->birthdate);
            return $user;
        });
        
        return view('user.index', compact('users'));
    }
    /**
     * Función para transformar la fecha según el idioma
     * Entradas: Fecha
     * Salidas: Fecha en diferentes formatos
     */
    public function dateTransform($date)
    {
        // Obtención del idioma
        $locale = app()->getLocale();
        // Conversión del formato de la fecha
        $date = Carbon::parse($date);
        // Define los formatos para cada idioma
        $formats = [
            'en' => 'DD-MMM-YYYY', // Formato en inglés
            'es' => 'DD-MM-YYYY', // Formato en español
        ];
        // Si el locale actual no está en el array de formatos, usa un formato predeterminado
        $format = $formats[$locale];
        // Configura el locale en Carbon y devuelve el formato
        return $date->locale($locale)->isoFormat($format);
    }
    


    /**
     * Función para almacenar un registro
     * Entradas: Datos de usuario [
     * - Nombre completo
     * - Fecha de nacimiento
     * - Teléfono
     * - Correo electrónico
     * ]
     * Salidas: Mensajes [
     * - Error: Anomalías en el formato o valor de los inputs
     * - Éxito: Registro agregado correctamente
     * ]
     */
    public function store(UserRequest $request): RedirectResponse
    {
        // Validación de reglas 
        $data = $request->validated();
        
        // Crear la fecha de nacimiento en formato 'Y-m-d'
        $birthdate = Carbon::createFromDate($data['year'], $data['month'], $data['day'])->format('Y-m-d');
        // Creación de contraseña
        $password = $this->makePassword();
        
        // Crear un nuevo usuario
        User::create([
            'name' => $data['name'],
            'first_lastname' => $data['first_lastname'],
            'second_lastname' => $data['second_lastname'],
            'birthdate' => $birthdate,
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($password),
        ]);
    
        // Redirigir con mensaje de éxito
        return Redirect::route('user.index')
            ->with('store', 'store');
    }

    /**
     * Función para generar contraseña aleatoria
     * Entradas: Ninguna
     * Salidas: Contraseña (Mayúsculas, minúsculas, números y signos)
     */
    private function makePassword(){
        // Definición de carácteres permitidos
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $number = '1234567890';
        $character = '!@#$%^&*()~{}[]+-';
        // Definición de contraseña
        $upr_pass = substr(str_shuffle($upper), 0, 2);
        $low_pass = substr(str_shuffle($lower), 0, 3);
        $num_pass = substr(str_shuffle($number), 0, 3);
        $cha_pass = substr(str_shuffle($character), 0, 2);
        $password = $upr_pass . $low_pass . $num_pass . $cha_pass;

        return $password;
    }

    /**
     * Función para mostrar un registro
     * Entradas: ID del usuario
     * Salidas: Datos de usuario [
     * - Nombre completo
     * - Fecha de nacimiento | Edad
     * - Teléfono
     * - Correo electrónico
     * - Foto
     * ]
     */
    public function show($id): View
    {
        // Obtener el registro del usuario mediante ID
        $user = User::find($id);
        // Obtener y convertir la fecha de nacimiento
        $birthdate = Carbon::parse($user->birthdate);
        // Obtener la edad del usuario
        $age = $birthdate->age;
        
        return view('user.show', compact('user', 'age'));
    }

    /**
     * Función para actualizar registro
     * Entradas: Datos nuevos para actualizar, usuario a modificar
     * Salidas: [
     * - Error: Anomalías en el formato o valor de los inputs
     * - Éxito: Registro actualizado correctamente
     * ]
     */
    public function update(UserRequest $request, $id): RedirectResponse
    {
        $user = User::find($id);
        
        // Construir el array con todos los datos a actualizar
        $birthdate = Carbon::createFromDate(
            $request->input('year'),
            $request->input('month'),
            $request->input('day')
        );
        
        $userData = array_merge(
            $request->validated(),
            [
                'name' => $request->input('name'),
                'first_lastname' => $request->input('first_lastname'),
                'second_lastname' => $request->input('second_lastname'),
                'birthdate' => $birthdate,
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ]
        );
    
        // Actualizar el usuario con todos los datos
        $user->update($userData);

        
        return Redirect::back()
            ->with('update', 'update');
    }
    

    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();

        return Redirect::route('user.index')
            ->with('delete', 'delete');
    }
}
