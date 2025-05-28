<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Exports\CitiesExport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cities = City::orderBy('name', 'asc')->paginate(6);
            return view('cities.index', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al obtener las ciudades: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('cities.create');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
        }
    }

    /**
     * Import CSV/XLS into cities.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        $rows = Excel::toCollection(null, $request->file('file'))[0];

        $cities = [];
        $errors = [];

        foreach ($rows->skip(1) as $idx => $row) {
            $data = [
                'name'        => $row[0],
                'description' => $row[1] ?? null,
            ];

            $validator = Validator::make($data, [
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                $errors[$idx + 2] = $validator->errors()->all();
            }

            $cities[$idx + 2] = $data;
        }

        session([
            'import_cities' => $cities,
            'import_errors' => $errors,
        ]);

        if (!empty($errors)) {
            return redirect()->route('cities.import.errors');
        }

        return redirect()->route('cities.import.errors')
            ->with('success', 'All rows valid—confirm to save.');
    }

    /**
     * Show import errors & preview.
     */
    public function importErrors()
    {
        $cities = session('import_cities', []);
        $errors = session('import_errors', []);
        return view('cities.import_errors', compact('cities', 'errors'));
    }

    /**
     * Save imported cities after confirmation.
     */
    public function saveImported(Request $request)
    {
        $cities = $request->input('cities', []);
        foreach ($cities as $city) {
            City::create($city);
        }
        session()->forget(['import_cities', 'import_errors']);
        return redirect()->route('cities.index')
            ->with('success', 'Ciudades importadas exitosamente.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            City::create($request->all());
            return redirect()->route('cities.index')
                ->with('success', 'Ciudad creada con éxito');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $city = City::findOrFail($id);
            return view('cities.show', compact('city'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al obtener la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $city = City::findOrFail($id);
            return view('cities.edit', compact('city'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $city = City::findOrFail($id);
            $city->update($request->all());
            return redirect()->route('cities.index')
                ->with('success', 'Ciudad actualizada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();
            return redirect()->route('cities.index')
                ->with('success', 'Ciudad eliminada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Export all cities as CSV.
     */
    public function exportCsv()
    {
        return Excel::download(
            new CitiesExport,
            'cities.csv',
            \Maatwebsite\Excel\Excel::CSV,
            ['Content-Type' => 'text/csv']
        );
    }

    /**
     * Export all cities as XLSX.
     */
    public function exportXls()
    {
        return Excel::download(
            new CitiesExport,
            'cities.xlsx',
            \Maatwebsite\Excel\Excel::XLSX
        );
    }
}
