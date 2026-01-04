@extends('layouts.app')
@section('title', 'Perfil')
@section('content')
<!DOCTYPE html>
<body>

    @if ($mensagem = Session::get('sucesso'))
        <p>{{$mensagem}}</p>
    @endif


    <form action="{{ route('store.profile', ['id' => $user->id])}}" method="post"> <!-- [] nesta linha tem um array -->
        @csrf
        @method('PUT')
        <label for="nome">Nome</label>
        <input type="text" name="name" value="{{ $user->name }}" id="nome"><br>
        <label for="email">Email</label>
        <input type="email" name="email" value="{{ $user->email }}" id="email"><br>
        <input type="submit" value="Atualizar">
    </form>
    <form action="{{ route('destroy.profile', ['id' => $user->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Destroy">
    </form>
</body>
</html>
@endsection
