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
    <p>Voulez vous supprimer vraimenet cet article ?</p>
    <div>
            <h3>
                <a href = '{{route('nodelete')}}' style="color:royalblue">Non</a>
                <a href = '/delete/{{$articleRemove[0]->id}}' style="color:red">Oui</a>                                       
            </h3>
    </div>
@endsection