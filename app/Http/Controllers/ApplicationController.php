<?php

// app/Http/Controllers/ApplicationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Application;

use App\Mail\ApplicationSubmitted;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        // Validação básica (opcional)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'observations' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:1024',
        ]);
        // Upload do arquivo
        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('applications', 'public');
        }

        $ipAddress = $request->ip(); // Captura o IP do usuário

        // Salvar no banco
        $application = Application::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'position' => $validated['position'] ?? null,
            'education' => $validated['education'] ?? null,
            'observations' => $validated['observations'] ?? null,
            'file_path' => $path,
            'submitted_at' => now(),
            'ip_address' => $ipAddress,
        ]);

        // Envia o e-mail
        try {
            Mail::to('seuemail@gmail.com')->send(new ApplicationSubmitted($application));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar e-mail: ' . $e->getMessage());
        }
        
        return response()->json([
            'message' => 'Currículo enviado com sucesso!',
            'data' => $application,
        ]);

    }
}


