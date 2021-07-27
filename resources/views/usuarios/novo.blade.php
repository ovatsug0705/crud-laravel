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
<form action="{{ route('usuarios.add') }}" method="post" enctype="multipart/form-data">
@else
<form action="{{ route('usuarios.update', $usuario["id"]) }}" method="post" enctype="multipart/form-data">
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

    <fieldset class="form-group">
        <label for="email">Imagem:</label>
        <input type="file" required name="image_path" id="image_path" accept="image/png,image/jpg,image/jpeg" class="form-control">
    </fieldset>

    <hr>

    <button type="submit" class="btn btn-info">Enviar</button>
</form>
@endsection
