@extends('base')

@section('title')
    Acceuil
@endsection

@section('list')
    @if (session()->has('user'))
        <li style="margin-right:20px">
            <a style="text-decoration: none; color: white;" href="/dashboard/{{ session()->get('user')['id']}}">Tableau de bord</a>
        </li>

        <form method="POST" action="{{route('logout')}}">
            @csrf
            <li>
                <button type="submit" style="background-color:none; border: none">
                    <a style="text-decoration: none; color:darkblue;">Déconnexion</a>
                </button>
            </li>
        </form>

    @else
        <li>
            <button style="background-color:none; border: none; margin-right:20px">
                <a style="text-decoration: none; color:darkblue;" href="{{route('create_user')}}">Inscription</a>
            </button>
            <button style="background-color:none; border: none">
                <a style="text-decoration: none; color:darkblue;" href="{{route('showlogin')}}">Connexion</a>
            </button>
        </li>
    @endif
@endsection

@section('content')
    <h1>HomePage</h1>
    <div>
        <form method="GET" action="{{route('search.page')}}">
            @csrf
            <label for="search">Search</label>
            <input type="text" placeholder="Search.." name="search">
            <button type="submit">ok</button>
        </form>
    </div>
    @foreach ($categories as $categorie)
        
        <h1>{{$categorie->nameCat}}</h1>
        @foreach ($articles as $article)
            @if ($categorie->nameCat ==  $article['id_cat'])
            <livewire:article :article="$article"/> 
            @endif
        @endforeach
    @endforeach
@endsection