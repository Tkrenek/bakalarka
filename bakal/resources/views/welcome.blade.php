@extends('layouts.navigation')

@section('content')
  <h1>Vítejte v IS</h1>

  Jako kdo chcete pokračovat?

  Zákazník: <a  class="nav-link" href="{{ route('subscribers.login') }}" class="p-3">Přihlášení zákazníka</a> nebo <a href="{{ route('subscribers.create') }}">registrovat</a> .
  
  Zaměstnanec: <a href="{{ route('employees.login') }}">přihlásit</a> se nebo  <a href="{{ route('employees.create') }}">registrovat</a>.

  Admin: <a href="{{ route('admins.login') }}">přihlásit</a> se nebo <a href="{{ route('admins.index') }}">registrovat</a>.
@endsection