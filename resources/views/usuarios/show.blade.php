@extends('layouts.app')

@section('content')
    <h1 style="margin-bottom: 20px">Detalhes do usuário</h1>

    <div style="margin-bottom: 20px">
        <a href="{{ route('usuarios.home') }}">Voltar</a>
    </div>

    <hr>

    <div>
        <p><strong>ID:</strong> {{ $usuario["id"] }}</p>
        <p><strong>Nome:</strong> {{ $usuario["name"] }}</p>
        <p><strong>E-mail:</strong> {{ $usuario["email"] }}</p>
    </div>

    <hr>

    <h2>Tarefas</h2>
    @if (!empty($tasks))
        <table>
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Status</th>
            </tr>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task['id'] }}</td>
                <td>{{ $task['title'] }}</td>
                <td>{{ $task['description'] }}</td>
                <td>{{ $task['finished'] == 0 ? 'Não finalizado' : 'Finalizado' }}</td>
            </tr>
            @endforeach
        </table>
    @else
        <p>Nenhuma tarefa alocada.</p>
    @endif
@endsection