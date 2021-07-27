<form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="file" name="arquivo" id="file">
    <button type="submit">Salvar arquivo</button>
</form>