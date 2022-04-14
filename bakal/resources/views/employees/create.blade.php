@extends('layouts.navigation')

@section('content')
  

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header text-center">Registrace zaměstnance</div>

            <div class="card-body">
        
            <form action="{{ route('employees.store') }}" method="POST">
                @csrf
               
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                    
                            <label for="name">Jméno</label>
                           
                            <input type="text" value="{{ old('name') }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                            <div class="invalid-feedback">
                                @error('name')
        
                                    Musíte zadat jméno.
                    
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            
                            <label for="surname">Příjmení</label>
                            <input type="text" value="{{ old('surname') }}" id="surname" name="surname" class="form-control @error('surname') is-invalid @enderror">
                            <div class="invalid-feedback">
                                @error('surname')
        
                                    Musíte zadat příjmení.
                    
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>
                
                
                <div class="form-group">
                   
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
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

                    <label for="password_confirmation">Ověření hesla</label>
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
                <div class="form-group ">
                    
                    <label for="email">E-mail</label>
                    <input type="text" id="email" placeholder="jmeno@domena.cz" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('email')
                            @if($message == "The email has already been taken.")
                                Tento email už je obsazen.
                            @else
                                Musíte zadat e-mail ve správném formátu.
                            @endif

                            
            
                        @enderror
                    </div>
                </div>
                <div class="form-group ">
                   
                    <label for="phone">Telefonní číslo</label>
                    <input type="text" id="phone" value="{{ old('phone') }}"  name="phone" class="form-control @error('phone') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('phone')

                            Musíte zadat telefonní číslo, které není obsazené.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    
                    <label for="function">Funkce</label>
                    <input type="text" id="function"  name="function" value="{{ old('function') }}" class="form-control @error('function') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('function')

                            Musíte zadat funkci, kterou bude zaměstnanec vykonávat.
            
                        @enderror
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label for="birth_date">Datum narození</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
                    <div class="invalid-feedback">
                        @error('birth_date')

                            Musíte zadat datum narození. 
            
                        @enderror
                    </div>  
                </div>
                <!--
                <div class="form-group">
                    <label for="birth_date">Datum narození</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
                    <div class="invalid-feedback">
                        @error('birth_date')

                            {{  $message }}
            
                        @enderror
                    </div>  
                </div>
            -->
                <div class="form-group ">
                    
                    <label for="department">Oddělení</label>
                    <select name="department" id="department" class="form-control custom-select">
                        @foreach ($departments as  $dep)
                        <option id="{{ $dep->name }}" name="{{ $dep->name }}">{{ $dep->name }}</option class="form-control @error('department') is-invalid @enderror">
                        @endforeach
                    </select> 
                    <div class="invalid-feedback">
                        @error('department')

                            Musíte vybrat oddělení.
            
                        @enderror
                    </div>   
  
                </div>

          
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Registrovat zaměstnance</button>

                </div>
                
            </form>
         
       
    </div>

    
            </div></div></div></div>
       
@endsection