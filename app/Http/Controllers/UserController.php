<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Si el usuario está autenticado, devuelve el usuario logeado
            return Auth::user();
        } else {
            // Si el usuario no está autenticado, devuelve una respuesta "Unauthorized"
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:8'
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'password' => Hash::make(request()->input('password'))
        ]);
        return response()->json([
            'status' => true,
            'message' => "Usuario creado",
            'token' => $user->createToken('API Token')->plainTextToken
        ], 200);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $User)
    {
        return $User;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return $user;
    }
    public function iniciarSesion(Request $request)
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => ['Unauthorized']
            ], 401);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => "Usuario logeado",
            'token' => $token,
            'user' => $user
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->estado = 0;
        $user->save();
        return $user;
    }
    public function logout(Request $request)
    {
        // Verificar si hay un usuario autenticado
        if ($request->user()) {
            // Eliminar todos los tokens del usuario
            $request->user()->tokens()->delete();

            // Cerrar sesión
            Auth::guard('web')->logout();
        }


        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }
}
