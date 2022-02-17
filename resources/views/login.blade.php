@extends('base')

@section('title')
    Connexion
@endsection

@section('content')
    <h1>Se connecter</h1>
    <div>
        <form method="POST" action="{{route('login')}}">
            @csrf
            @if ($errors->any())
                <div style="background-color: red; color:white">
                Vous n'avez pas pu être authentifié &#9785;
                </div>
            @endif

            <label for="email">Email</label>
            <input type="email" placeholder="Email.." name="email" required>
            <br><br>
            <label for="password">Mot de passe</label>
            <input type="password" placeholder="mot de passe.." name="password" required>
            <br><br>
            <button type="submit">se connecter</button>
        </form>
    </div>
@endsection