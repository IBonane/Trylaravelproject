@extends('base')

@section('title')
    Creation
@endsection

@section('content')
    <h1>Modifier article</h1>
    <div>
        <form method="POST" action='/update/{{$articleFind[0]->id}}'>
            @csrf
            <label for="name">Nom</label>
            <input type="text" placeholder="Nom.." name="name" value="{{$articleFind[0]->name}}" required>
            <br><br>
            <label for="price">Prix</label>
            <input type="text" placeholder="Prix.." name="price" value="{{$articleFind[0]->price}}" required>
            <br><br>
            <button type="submit">Modifier</button>
        </form>
    </div>
@endsection