<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::all();

        return response()->json([
            'data' => $pacientes,
            'status' => true,
            'code' => 200,
            'message' => 'Lista de pacientes obtenida correctamente.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $paciente = Paciente::create($request->all());

        return response()->json([
            'data' => $paciente,
            'status' => true,
            'code' => 201,
            'message' => 'Paciente creado exitosamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paciente = Paciente::find($id);

        if ($paciente) {
            return response()->json([
                'data' => $paciente,
                'status' => true,
                'code' => 200,
                'message' => 'Paciente obtenido correctamente.'
            ]);
        } else {
            return response()->json([
                'data' => null,
                'status' => false,
                'code' => 404,
                'message' => 'Paciente no encontrado.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $paciente = Paciente::find($id);

        if ($paciente) {
            $paciente->update($request->all());

            return response()->json([
                'data' => $paciente,
                'status' => true,
                'code' => 200,
                'message' => 'Paciente actualizado correctamente.'
            ]);
        } else {
            return response()->json([
                'data' => null,
                'status' => false,
                'code' => 404,
                'message' => 'Paciente no encontrado.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paciente = Paciente::find($id);

        if ($paciente) {
            $paciente->delete();

            return response()->json([
                'data' => null,
                'status' => true,
                'code' => 200,
                'message' => 'Paciente eliminado correctamente.'
            ]);
        } else {
            return response()->json([
                'data' => null,
                'status' => false,
                'code' => 404,
                'message' => 'Paciente no encontrado.'
            ]);
        }
    }
}
