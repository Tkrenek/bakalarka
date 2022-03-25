@extends('layouts.navigation')

@section('content')
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Změna hesla</div>

            <div class="card-body"> 
            <form  action="{{ route('subscribers.update_passwordAdmin', $customer->id) }}" method="POST">
                @csrf
               
             
                <div class="form-group">
                    
                    <label for="password" class=>Nové heslo</label>
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
                <div class="form-group">
                    
                    <label for="password_confirmation">Ověření hesla</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation" >
                    <div class="invalid-feedback">
                        @error('password')
                            @if($message == "The password confirmation does not match.") 
                                Hesla se neshodují.
                            @else
                                Musíte zadat heslo.
                            @endif
                         
            
                        @enderror
                    </div>    
                </div>
                
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary ">Změnit heslo</button>

                </div>
            </form>
        

            </div>

            </div>
        </div>
    </div>
</div>
</div>

@endsection