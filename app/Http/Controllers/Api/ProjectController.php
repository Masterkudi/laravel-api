<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        // Tramite questo controller recupero i dati dal DB
        // $projects = Project::all();

        // recupera i dati dal DB e li pagina interfacciandosi con il model Project
        $projects = Project::with('user', 'type', 'technologies')->paginate(10);
        // Restituisco i dati in formato JSON
        return response()->json($projects);
    }
}
