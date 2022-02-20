@extends('base')

@section('title')
    Inscription
@endsection

@section('content')
    <h1>S'inscrire</h1>
    <div>
        <form method="POST" action="{{route('user.post')}}">
            @csrf
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                <ol><li>{{$error}}</li></ol>
                @endforeach
                
                </div>
            @endif
            <label for="pseudo">Pseudo</label>
            <input type="text" placeholder="Pseudo.." name="pseudo" required>
            <span style="color: red">*</span>
            <br>
            {{-- @error('pseudo')
            <div style="color: red">
              {{ $message }}
            </div>
            @enderror --}}
            <br><br>
            <label for="lastname">Nom</label>
            <input type="text" placeholder="Nom.." name="lastname" >
            <br><br>
            <label for="firstname">Prenom</label>
            <input type="text" placeholder="Prenom.." name="firstname" >
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
            @error('password')
            <div style="color: red">
              {{ $message }}
            </div>
            @enderror
            <br><br>
            <label for="password_confirm">confirmation de mot de passe</label>
            <input type="password" placeholder="confirmation de mot de passe.." name="password_confirm" required>
            <span style="color: red">*</span>
            <br>
            {{-- @error('password_confirm')
            <div style="color: red">
              {{ $message }}
            </div>
            @enderror --}}
            <br><br>
            <button type="submit">s'inscrire</button>
        </form>
    </div>
@endsection