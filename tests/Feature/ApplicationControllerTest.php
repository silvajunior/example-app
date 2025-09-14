<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Application;
use App\Mail\ApplicationSubmitted;

class ApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_application_successfully()
    {
        // Finge que o disco 'public' existe
        Storage::fake('public');

        // Finge que o e-mail será enviado
        Mail::fake();

        // Dados simulados
        $data = [
            'name' => 'João da Silva',
            'email' => 'joao@example.com',
            'phone' => '11999999999',
            'position' => 'Desenvolvedor',
            'education' => 'Ensino Superior',
            'observations' => 'Nenhuma observação.',
            'file' => UploadedFile::fake()->create('curriculo.pdf', 200, 'application/pdf'),
        ];

        // Faz a requisição POST
        $response = $this->postJson('/api/applications', $data); // Ajuste a rota conforme sua aplicação

        // Verifica o status
        $response->assertStatus(200);

        // Verifica estrutura da resposta
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id', 'name', 'email', 'phone', 'position', 'education',
                'observations', 'file_path', 'submitted_at', 'ip_address',
                'created_at', 'updated_at'
            ]
        ]);

        // Verifica se o arquivo foi armazenado
        Storage::disk('public')->assertExists('applications/' . $data['file']->hashName());

        // Verifica se o e-mail foi enviado
        Mail::assertSent(ApplicationSubmitted::class, function ($mail) use ($data) {
            return $mail->application->email === $data['email'];
        });

        // Verifica se foi salvo no banco
        $this->assertDatabaseHas('applications', [
            'email' => $data['email'],
            'name' => $data['name'],
        ]);
    }
}
