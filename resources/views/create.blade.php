@extends('base')

@section('title')
    Creation
@endsection

@section('content')
    <h1>Ajout de nouvel article</h1>
    <div>
        <form method="POST" action="{{route('create')}}" enctype="multipart/form-data">
            @csrf

            <label for="name">Nom</label>
            <input type="text" placeholder="Nom.." name="name" required>
            <br><br>

            <label for="price">Prix</label>
            <input type="text" placeholder="Prix.." name="price" required>
            <br><br>

            <label for="image_article">image</label>
            <input type="file" id="image_article" name="image_article" accept="image/png, image/jpeg">
            <br><br>

            <button type="submit">créer</button>
        </form>
    </div>
@endsection