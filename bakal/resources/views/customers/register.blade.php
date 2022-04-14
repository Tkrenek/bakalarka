@extends('layouts.navigation')

@section('content')
  @guest
  <div class="justify-content-center d-flex p-5"><h1>Informační systém Colorex</h1></div>
  <div class="justify-content-center d-flex p-1">Jste zaměstnanec? Klikněte: <a href="{{ route('employees.login') }}"> zde </a>.</div>
  @endguest

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">Registrace zákazníka</div>

                <div class="card-body ">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
               
                
                <div class="form-group">
                    
                    <label for="name" class="form-label">Název společnosti</label>
                    
                    <input type="text" value="{{ old('name') }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('name')

                            Musíte zadat název společnosti.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    
                    <label for="town" class="form-label">Město</label>
                  
                    <input type="text" value="{{ old('town') }}" id="town" name="town" class="form-control @error('town') is-invalid @enderror">
              
                    <div class="invalid-feedback">
                        @error('town')

                            Musíte zadat město, ve kterém společnost sídlí.
            
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                   
                    <label for="address" class="form-label">Adresa</label>
                    <input type="text" id="address" value="{{ old('address') }}" name="address" class="form-control @error('address') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('address')

                            Musíte zadat adresu, na které společnost sídlí.
            
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    
                    <label for="login" class="form-label">Login</label>
                    <input type="text" id="login" value="{{ old('login') }}" name="login" class="form-control @error('login') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('login')

                            Musíte zadat login, který není obsazen.
            
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    
                    <label for="password" class="form-label">Heslo</label>
                    <input type="password" id="password"  name="password" class="form-control @error('password') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('password')
                            @if ($message == "The password confirmation does not match.")
                                Hesla se musí shodovat.
                            @else
                                Musíte zadat heslo.
                            @endif

                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    
                    <label for="password_confirmation" class="form-label">Ověření hesla</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('password')
                            @if ($message == "The password confirmation does not match.")
                                Hesla se musí shodovat.
                            @else
                                Musíte zadat heslo.
                            @endif

                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    
                    <label for="url" class="form-label">URL(nepovinné)</label>
                    <input type="text" value="{{ old('url') }}" id="url" name="url" class="form-control @error('url') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('url')

                            Musíte zadat url adresu.
            
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Registrovat zákazníka</button>

                </div>
            </form>
            @guest
                <span>Pokud již účet máte, přihlaste se: <a href="{{ route('customers.login') }}">zde</a></span>
            @endguest
            </div>
        </div> 
        @guest
        Přístup pro admina: <a href="{{ route('admins.login') }}">zde</a>.
    </div>
        @endguest
       
        </div>
        
        </div>
        

@endsection