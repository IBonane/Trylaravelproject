@extends('base')

@section('title')
    Description
@endsection

@section('content')
    <h1>Article</h1>
    <div class="addthis_inline_share_toolbox">
        <h3>
            {{ $article[0]->id }}- {{ $article[0]->name }} :  {{ $article[0]->price }} $            
        </h3>
        <img src="{{ Storage::url($article[0]->path_image) }}" alt="image article" style="width: 800px; height:500px; margin-left: 20px">
        <a href="/article/{{$article[0]->id}}/download">Télécharger la recette en pdf</a>

        <h3>Ingredients</h3>
        <ul>
            @foreach ($Pages as $Page)
                <li value="{{$Page->namePage}}">{{$Page->namePage}}</li>
            @endforeach
        </ul>

        <h3>Description</h3>
        <ol>
            @foreach ($etapes as $etape)
                <li>{{$etape}}</li>
            @endforeach
        </ol>

    </div>
@endsection