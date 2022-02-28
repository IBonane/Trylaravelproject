@extends('base')

@section('title')
    Creation
@endsection

@section('content')
    <h1>Modifier article</h1>
    <div>
        <form method="POST" action='/update/{{$articleFind[0]->id}}' enctype="multipart/form-data">
            @csrf
            <label for="name">Nom</label>
            <input type="text" placeholder="Nom.." name="name" value="{{$articleFind[0]->name}}" required>
            <br><br>

            <label for="price">Prix</label>
            <input type="text" placeholder="Prix.." name="price" value="{{$articleFind[0]->price}}" required>
            <br><br>

            <select name="categorie" id="categorie">Categorie
            @foreach ($categories as $categorie)
                <option value="{{$categorie->nameCat}}" @if ($articleFind[0]->id_cat == $categorie->nameCat) selected @endif>
                    {{$categorie->nameCat}}
                </option>
            @endforeach
            </select>
            <br><br>

            <label for="image_article">image</label>
            <input type="file" id="image_article" name="image_article" accept="image/png, image/jpeg">
            <br><br>
            <button type="submit">Modifier</button>
        </form>
    </div>
@endsection