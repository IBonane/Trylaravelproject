@extends('base')

@section('title')
    Description
@endsection

@section('content')
    <h1>Article</h1>
    <div>
        <h3>
            {{ $article[0]->id }}- {{ $article[0]->name }} :  {{ $article[0]->price }} $ 
            <a href="" ><div class="addthis_inline_share_toolbox"></div></a>                
        </h3>
    </div>
@endsection