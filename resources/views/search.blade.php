@extends('base')

@section('title')
    Recherche
@endsection

@section('content')
<h1>Search Results</h1>
<div>
    @if (empty($queries)) 
    <p>Désolé Aucun Article trouvé pour cette Recherche...</p>
    @endif  
    @foreach ($queries as $query)
        <h3>
            {{ $query->id }}- {{ $query->name }} :  {{ $query->price }} $
            <a href = '/article/{{$query->id}}' style="color:orange">Detail</a>
        </h3>
    @endforeach
</div>
@endsection