@extends('layouts.navigation')

@section('content')
  

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Přihlášení admina</div>

            <div class="card-body">
            <form  action="{{ route('admins.login.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        

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
                            @if($message == "The password confirmation does not match.") 
                                Hesla se neshodují.
                            @else
                                Musíte zadat heslo.
                            @endif
                         
            
                        @enderror
                </div>
               
                
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přihlásit admina</button>

                </div>
            </form>
       

            </div>

            </div>
        </div>
    </div>
</div>

@endsection