<?php

namespace App\Http\Controllers;
use App\Models\Citizen;
use App\Models\City;

use Illuminate\Http\Request;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $citizens = Citizen::orderBy('first_name', 'asc')->paginate(6);
            return view('citizens.index', compact('citizens'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener los ciudadanos: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        try {
            $cities = City::orderBy('name', 'asc')->get();
            return view('citizens.create', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx,xls']);

        $rows = Excel::toCollection(null, $request->file('file'))[0];

        $citizens = [];
        $errors = [];

        foreach ($rows->skip(1) as $index => $row) {
            $data = [
                'first_name' => $row[0],
                'last_name' => $row[1],
                'birth_date' => $row[2],
                'city_id' => $row[3],
                'address' => $row[4],
                'phone' => $row[5],
            ];

            $validator = Validator::make($data, [
                'first_name' => 'required|string|max:60',
                'last_name' => 'required|string|max:60',
                'birth_date' => 'required|date|before:today',
                'city_id' => 'required|exists:cities,id',
                'address' => 'nullable|string|max:1000',
                'phone' => 'nullable|string|max:15',
            ]);

            if ($validator->fails()) {
                $errors[$index + 2] = $validator->errors()->all();
            }

            $citizens[$index + 2] = $data;
        }

        session(['import_citizens' => $citizens, 'import_errors' => $errors]);

        if (!empty($errors)) {
            return redirect()->route('citizens.import.errors');
        }

        return redirect()->route('citizens.import.errors')->with('success', 'Todo válido, confirme para guardar.');
    }

    public function importErrors()
    {
        $citizens = session('import_citizens', []);
        $errors = session('import_errors', []);

        return view('citizens.import_errors', compact('citizens', 'errors'));
    }

    public function saveImported(Request $request)
    {
        $citizens = $request->input('citizens', []);

        foreach ($citizens as $citizen) {
            Citizen::create($citizen);
        }

        session()->forget(['import_citizens', 'import_errors']);

        return redirect()->route('citizens.index')->with('success', 'Ciudadanos importados correctamente.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'birth_date' => 'required|date|before:today',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:15',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'city_id.required' => 'La ciudad es obligatoria.',
            'address.max' => 'La dirección no puede exceder los 1000 caracteres.',
            'phone.max' => 'El teléfono no puede exceder los 15 caracteres.',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.'
        ]);
        try {
            Citizen::create($request->all());
            return redirect()->route('citizens.index')->with('success', 'Ciudadano creado con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el ciudadano: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            return view('citizens.show', compact('citizen'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener el ciudadano: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            $cities = City::orderBy('name', 'asc')->get();
            return view('citizens.edit', compact('citizen', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'birth_date' => 'required|date',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:15',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'city_id.required' => 'La ciudad es obligatoria.',
            'address.max' => 'La dirección no puede exceder los 1000 caracteres.',
            'phone.max' => 'El teléfono no puede exceder los 15 caracteres.',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
        ]);
        try {
            $citizen = Citizen::findOrFail($id);
            $citizen->update($request->all());
            return redirect()->route('citizens.index')->with('success', 'Ciudadano actualizado con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el ciudadano: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            $citizen->delete();
            return redirect()->route('citizens.index')->with('success', 'Ciudadano eliminado con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el ciudadano: ' . $e->getMessage());
        }
    }
}
