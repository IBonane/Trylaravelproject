@extends('base')

@section('title')
    Inscription
@endsection

@section('content')
    <h1>Validation de compte</h1>
    <div>
        <p style="color: orangered">veuillez saisie dans le champ token le code token que vous avez reçu par mail après votre inscription</p>
        {{-- @if ($message = Session::get('success'))
            {{$message}}
        @endif --}}
        <form method="POST" action="{{route('code.post')}}">
            @csrf
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                <ol><li>{{$error}}</li></ol>
                @endforeach
                
                </div>
            @endif
            <label for="token">Token de confirmation</label>
            <input type="text" placeholder="token.." name="token" required>
            <span style="color: red">*</span>
            <br>
            {{-- @error('pseudo')
            <div style="color: red">
              {{ $message }}
            </div>
            @enderror --}}
            <br><br>
            <label for="email">Email</label>
            <input type="email" placeholder="Email.." name="email" required>
            <span style="color: red">*</span>
            <br>
            {{-- @error('email')
            <div style="color: red">
              {{ $message }}
            </div>
            @enderror --}}
            <br><br>
            <label for="password">Mot de passe</label>
            <input type="password" placeholder="mot de passe.." name="password" required>
            <span style="color: red">*</span>
            <br>
            {{-- @error('password')
            <div style="color: red">
              {{ $message }}
            </div>
            @enderror --}}
            <br><br>
            <button type="submit">Valider</button>
        </form>
    </div>
@endsection