@extends('layouts.app')

@section('content')
    <h1>Lista de usuários</h1>

    @if (session()->has('success'))
        <div class="alert alert-success">
            <p style="margin-bottom: 0">{{ session()->get('success') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            <p style="margin-bottom: 0">{{ session()->get('error') }}</p>
        </div>
    @endif
    
    <div style="margin: 20px 0;">
        <a class="btn btn-primary" href="{{ url('usuarios/novo') }}">Novo Usuário</a>
    </div>

    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Email</th>
            <th colspan="3"></th>
        </tr>
        @foreach ( $usuarios as $u )
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>
                <a href="http://localhost:8080/usuarios/editar/{{ $u->id }}" class="btn btn-info">Editar</a>
            </td>
            <td>
                <a href="http://localhost:8080/usuarios/detalhes/{{ $u->id }}" class="btn btn-secondary">Ver</a>
            </td>
            <td>
                <form action="http://localhost:8080/usuarios/deletar/{{ $u->id }}" method="post" >
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger" type="submit">Deletar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
