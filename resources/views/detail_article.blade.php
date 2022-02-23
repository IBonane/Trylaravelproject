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
        <img src="{{ Storage::url($article[0]->path_image) }}" alt="image article">
       
        {{-- <a href="" ><div class="addthis_inline_share_toolbox"></div></a>    --}}
    </div>
@endsection