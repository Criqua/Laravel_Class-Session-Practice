<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Imports\CitiesImport;
use App\Exports\CitiesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'El nombre de la ciudad es obligatorio.',
            'name.max'      => 'El nombre de la ciudad no puede exceder los 255 caracteres.',
            'description.max' => 'La descripción no puede exceder los 1000 caracteres.',
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
        ], [
            'name.required' => 'El nombre de la ciudad es obligatorio.',
            'name.max'      => 'El nombre de la ciudad no puede exceder los 255 caracteres.',
            'description.max' => 'La descripción no puede exceder los 1000 caracteres.',
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
     * Import cities from an Excel file.
     */
    public function showImportForm()
    {
        return view('cities.import');
    }

    /**
     * Import cities from an Excel or CSV file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        try {
            Excel::import(new CitiesImport, $request->file('file'));
            return redirect()->route('cities.index')
                ->with('success', 'Ciudades importadas con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al importar las ciudades: ' . $e->getMessage());
        }
    }

    /**
     * Export cities to a CSV file.
     */
    public function exportCsv()
    {
        try {
            return Excel::download(new CitiesExport, 'cities.csv', \Maatwebsite\Excel\Excel::CSV);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al exportar las ciudades: ' . $e->getMessage());
        }
    }

    /**
     * Export cities to an Excel file.
     */
    public function exportXlsx()
    {
        try {
            return Excel::download(new CitiesExport, 'cities.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al exportar las ciudades: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for importing cities.
     */
    public function exportPdf()
    {
        try {
            $cities = City::orderBy('name', 'asc')->get();
            $pdf = PDF::loadView('cities.pdf', compact('cities'))->setPaper('A4', 'landscape');
            return $pdf->download('cities_' . \date('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al exportar las ciudades a PDF: ' . $e->getMessage());
        }
    }
}
