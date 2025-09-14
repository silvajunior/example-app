<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Currículo Enviado</title>
</head>
<body>
    <h2>Novo currículo enviado</h2>

    <p><strong>Nome:</strong> {{ $application->name }}</p>
    <p><strong>Email:</strong> {{ $application->email }}</p>
    <p><strong>Telefone:</strong> {{ $application->phone }}</p>
    <p><strong>Vaga:</strong> {{ $application->position }}</p>
    <p><strong>Formação:</strong> {{ $application->education }}</p>
    <p><strong>Observações:</strong> {{ $application->observations }}</p>
    <p><strong>IP:</strong> {{ $application->ip_address }}</p>
    <p><strong>Data:</strong> {{ $application->submitted_at }}</p>

    @if ($application->file_path)
        <p><strong>Arquivo:</strong> 
            <a href="{{ asset('storage/' . $application->file_path) }}">Baixar currículo</a>
        </p>
    @endif
</body>
</html>
