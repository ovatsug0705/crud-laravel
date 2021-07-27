@extends('layouts.app')

@section('content')
<div style="margin-bottom: 10px">
    <a href="{{ route('usuarios.home') }}">Voltar</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin-bottom: 0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (empty($usuario))
<form action="{{ route('usuarios.add') }}" method="post">
@else
<form action="{{ route('usuarios.update', $usuario["id"]) }}" method="post">
@endif
    @csrf

    <fieldset class="form-group">
        <label for="name">Nome</label>
        <input type="text" required name="name" id="name" class="form-control" value="{{ old('name') ?? $usuario["name"] ?? '' }}">
    </fieldset>

    <fieldset class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" required name="email" id="email" class="form-control" value="{{ old('email') ?? $usuario["email"] ?? '' }}">
    </fieldset>

    <hr>

    <button type="submit" class="btn btn-info">Enviar</button>
</form>
@endsection
