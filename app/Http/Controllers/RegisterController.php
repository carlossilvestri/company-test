<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('business_name')->get();
        return view('auth.register', compact('companies'));
    }

    public function store(Request $request)
    {
        // dd($request); 
        // dd($request->get('username'));

        // Validacion
        $this->validate(
            $request,
            [
                'name' => 'required|max:30',
                'email' => 'required|unique:users|email|max:60',
                'password' => 'required|confirmed|min:6',
                'company_id' => 'required|exists:companies,id'
            ],
            [/* Must be empty */],
            [
                'name' => 'nombre',
                'email' => 'email',
                'password' => 'contraseña',
                'company_id' => 'empresa',
            ]
        );


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $request->company_id
        ]);

        // Autenticar un usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        // Otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));


        // Redireccionar
        return redirect()->route('home');
    }
}
