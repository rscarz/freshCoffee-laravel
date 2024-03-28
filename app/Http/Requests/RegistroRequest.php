<?php
// php artisan make:request RegistroRequest
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name'=> ['required' , 'string'] ,
            'email'=> ['required' , 'email' , 'unique:users,email'] ,
            'password' => [
                'required' ,
                'confirmed' 
                //,
                //PasswordRules::min(8)->letters()->symbols()->numbers()
            ]
        ];
    }

    public function messages()
    {
        return [
            'name' => 'El Nombre es obligatorio' , 
            'email.required' => 'El Email es obligatorio' , 
            'email.email' => 'El Email es es válido' , 
            'email.unique' => 'El usuario ya está registrado' , 
            'password' => 'El password debe contener al menos 8 caracteres, un símbolo y un número' , 
            'password.confirmed' => 'Los passwords ingresados no coinciden. '
        ] ;
    }
}
// Pero al final te sale mejor usar el paquete laravel-lang y poner las validaciones en espanol y usar messages() en el Request solo si es necesario.

// Para instalar Laravel-Lang solo tenes que  hacer esto:

// En una consola:

// $ sail composer require --dev laravel-lang/common
// $ sail artisan lang:add es


// Despues te vas a app.php (en config) y cambias 'locale' a 'es', y voila.