@extends('layouts.navigation')

@section('content')
    <form action="{{ route('customers.login') }}" method="POST">
        @csrf

        <label for="login">Login</label>
        <input type="text" id="login" name="login">

        <label for="password">heslo</label>
        <input type="text" id="password" name="password">

        <button type="submit" class="btn btn-primary">Přihlásit</button>
    </form>
@endsection