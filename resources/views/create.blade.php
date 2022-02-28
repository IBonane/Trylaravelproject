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

            <select name="categorie" id="categorie">Categorie
            @foreach ($categories as $categorie)
                <option value="{{$categorie->nameCat}}">{{$categorie->nameCat}}</option>
            @endforeach
            </select>
            <br><br>

            <div>

            </div>
                <div id="ajout">
                    <div id="1">
                        <label for="row[0]">Nom 1</label>
                        <input type="text" name="row[0]">
                    </div>
                    <br>
                </div>
                <br>
                <div>
                    <button type="button" id="plus">plus</button>
                    <button type="button" id="moins">moins</button>
                </div>
            </div>
            
            <br><br>

            <label for="image_article">image</label>
            <input type="file" id="image_article" name="image_article" accept="image/png, image/jpeg">
            <br><br>

            <button type="submit">créer</button>
        </form>
    </div>
@endsection
@section('script')
    <script  src="{{ asset('js/app.js') }}"></script>    
@endsection