<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Buscar todos os usuários com suas informações de perfil usando o método do modelo
            $users = User::getUsers();
            // Retornar os usuários como JSON
            return response()->json(['usuarios' => $users]);
        } catch (Exception $e) {
            // Se ocorrer uma exceção, retorna uma resposta de erro com uma mensagem
            return response()->json(['error' => 'Erro ao buscar usuários: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'perfils_id' => 'required',
            'telefone' => 'nullable|string',
            'endereco' => 'string',
            'rg' => 'nullable|string',
            'cpf' => 'required|string|unique:users',
        ]);

        // Crie um novo usuário usando os dados do request
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')), 
            'perfils_id' => $request->input('perfils_id'),
            'telefone' => $request->input('telefone'),
            'endereco' => $request->input('endereco'),
            'rg' => $request->input('rg'),
            'cpf' => $request->input('cpf'),
        ]);

        $user->save();

        return response()->json(['message' => 'Usuário criado com sucesso'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Encontrar o produto pelo ID
            $cliente = Cliente::findOrFail($id);
           
            // Atualizar os dados do produto
            $cliente->update([
                'nome' => $request->nome,
                'cpf' =>  $request->cpf,               
                'data_nascimento' => $request->data_nascimento,
                'sexo' => $request->sexo,
                'endereco' => $request->endereco,
                'estado' => $request->estado,
                'cidade' => $request->cidade,                
            ]);
           
            return response()->json(['message' => 'Cliente atualizado com sucesso!']);
        } catch (\Exception $e) {
            // Retorno de resposta JSON em caso de erro
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
