<?php
// php artisan make:controller AuthController
// php artisan make:request RegistroRequest
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistroRequest;

class AuthController extends Controller
{
    

    // public function register(Request $request) {
    public function register(RegistroRequest $request) {
        //validar el registro
        $data = $request->validated();

        //crear el usuario
        $user = User::create([
            'name' => $data['name'] , 
            'email' => $data['email'] , 
            'password' => bcrypt($data['password'] )
        ]);

        //retorna la respuesta
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ] ;
        
    } 

    public function login(LoginRequest $request) {
        $data = $request->validated(); 

        //revisar el password
        if (!Auth::attempt($data)) {
            return response ( [
                'errors' => ['el email o el password es incorrecto']
            ] , 422)  ;
        // 422 son datos incorrectos
        }

        //autenticar al usuario
        //se retorna tocken
        $user = Auth::user();

        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ] ;
        
    }

    public function logout(Request $request) {
        //return "Logout..." ; //-->test
        //obtnenmos el usuario
        $user = $request->user() ;

        //eliminamos el token
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    } 
}
