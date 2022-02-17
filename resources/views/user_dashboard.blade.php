@extends('base')

@section('title')
    Acceuil
@endsection

@section('list')
    @if (session()->has('user'))
        <li>
            <a style="text-decoration: none; color: white; margin-right:20px;">{{ session()->get('user')['email']}}</a>
        </li>
        <li>
            <a style="text-decoration: none; color: white; margin-right:20px;" href="{{route('home')}}">Accueil</a>
        </li>
        <form method="POST" action="{{route('logout')}}">
            @csrf
            <li>
                <button type="submit" style="background-color:none; border: none">
                    <a style="text-decoration: none; color:darkblue;">Déconnexion</a>
                </button>
            </li>
        </form>
    @endif
@endsection

@section('content')
    <h1>Tableau de board</h1>
    <div>
        @foreach ($articlesUser as $articleUser)
            <h3>
                {{ $articleUser->id }}- {{ $articleUser->name }} :  {{ $articleUser->price }} $ 
                <a href = '/update/{{$articleUser->id}}' style="color:royalblue">Modifier</a>
                <a href = '/delete/{{$articleUser->id}}' style="color:red">Supprimer</a>                                       
            </h3>
        @endforeach
    </div>
    <div>
        <a href="{{route('Showcreate')}}"><button>Ajouter article</button></a>
    </div>
@endsection