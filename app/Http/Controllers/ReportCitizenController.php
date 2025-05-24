<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citizen;
use App\Models\City;
use App\Mail\ReportMail;
use Illuminate\Support\Facades\Mail;

class ReportCitizenController extends Controller
{
    public function send_report(Request $request)
    {
        //Usuario autenticado
        $user = $request->user();
        $email = $user->email;

        $count_city = City::count();
        $count_citizen = Citizen::count();
        $datos = 'Registros a reportar: ' . $count_citizen . ' ciudadanos y ' . $count_city . ' ciudades.';
        $subject = "Bitacora";
        
        Mail::to($email)->send(new ReportMail($datos, $subject));
        return back()->with('success', 'Reporte enviado exitosamente.');
    }
}