@extends('layouts.navigation')

@section('content')
  
<div class="justify-content-center d-flex p-5"><h1>Informační systém Colorex</h1></div>
<div class="justify-content-center d-flex p-1">Jste zákazník? Klikněte: <a href="/"> zde </a>.</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Přihlášení zaměstnance</div>

            <div class="card-body">
            <form  action="{{ route('employees.login.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <strong>{{ $message }}  </strong>   
                        </div>    
                        
                        
                    @endif
                <div class="form-group">
                    
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email">
                    <div class="invalid-feedback">
                        @error('email')

                            Musíte zadat e-mail. 
            
                        @enderror
                    </div>     
                </div>

           
                <div class="form-group">
                    
                    <label for="password" class=>Heslo</label>
                    <input class="form-control @error('password') is-invalid @enderror"  type="password" id="password" name="password">
                    <div class="invalid-feedback">
                        @error('password')
                            
                                Musíte zadat heslo.
                            
                         
            
                        @enderror
                </div>
               
                
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přihlásit se</button>

                </div>
            </form>
    
       

            </div>

            </div>
           
        </div> 
    </div>
    
</div>
Přístup pro admina: <a href="{{ route('admins.login') }}">zde</a>.

@endsection