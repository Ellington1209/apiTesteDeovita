<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function index(Request $request)
    {
        $filtro = $request->only(['cpf', 'nome', 'dataNascimento', 'sexo', 'estado', 'cidade']);
        $pageSize = $request->input('pageSize', 10);      

        $clientesQuery = Cliente::query();

        foreach ($filtro as $campo => $valor) {
            if ($valor) {
                $clientesQuery->where($campo, 'like', "%$valor%");
            }
        }

        $clientes = $clientesQuery->paginate($pageSize);

        return response()->json([
            'clientes' => $clientes->items(),
            'totalPages' => $clientes->lastPage(),
        ], 200);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $cliente = Cliente::create($request->all());
            // Se você precisar retornar algo, como o ID do cliente inserido, você pode fazer assim:
            return response()->json(['message' => 'Cliente cadastrado com sucesso'], 201);
        } catch (\Exception $e) {
            // Se ocorrer uma exceção, você pode retornar uma resposta de erro
            return response()->json(['message' => 'Erro ao criar cliente: ' . $e->getMessage()], 500);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Encontrar o cliente pelo ID
            $produto = Cliente::findOrFail($id);

            // Excluir o cliente
            $produto->delete();

            // Retorno de resposta JSON em caso de sucesso
            return response()->json(['message' => 'Cliente excluído com sucesso!']);
        } catch (\Exception $e) {
            // Retorno de resposta JSON em caso de erro
            return response()->json(['error' => 'Erro ao excluir o cliente: ' . $e->getMessage()], 500);
        }
    }
}
