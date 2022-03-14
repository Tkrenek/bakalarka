@extends('layouts.navigation')

@section('content')
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Přidat zákazníka</div>

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
                
                
                <div class="form-group ">
                   
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
                <div class="form-group ">

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

                            Musíte zadat e-mail ve správném formátu.
            
                        @enderror
                    </div>
                </div>
                <div class="form-group ">
                   
                    <label for="phone">Telefonní číslo</label>
                    <input type="text" id="phone" value="{{ old('phone') }}"  name="phone" class="form-control @error('phone') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('phone')

                            Musíte zadat telefonní číslo.
            
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
                    <div class="row">
                        <div class="col">
                            <select id="day" name="day" class="form-select @error('day') is-invalid @enderror" aria-label="Default select example">
                                <option selected>Den</option>
                                @for ( $i = 1; $i < 32; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                                
                               
                              </select>
                              <div class="invalid-feedback">
                                @error('day')
        
                                    {{  $message }}
                    
                                @enderror
                            </div>  
                        </div>

                        <div class="col">
                            <select id="month" name="month" class="form-select @error('month') is-invalid @enderror" aria-label="Default select example">
                                <option selected>Měsíc</option>
                                <option value="1">Leden</option>
                                <option value="2">Únor</option>
                                <option value="3">Březen</option>
                                <option value="4">Duben</option>
                                <option value="5">Květen</option>
                                <option value="6">Červen</option>
                                <option value="7">Červenec</option>
                                <option value="8">Srpen</option>
                                <option value="9">Září</option>
                                <option value="10">Říjen</option>
                                <option value="11">Listopad</option>
                                <option value="12">Prosinec</option>
                              </select>
                              <div class="invalid-feedback">
                                @error('month')
        
                                    {{  $message }}
                    
                                @enderror
                            </div>  
                        </div>
                        <div class="col">
                            <select id="year" name="year" class="form-select @error('year') is-invalid @enderror" aria-label="Default select example">
                                <option selected>Rok</option>
                                    @for ( $i = 1955; $i < 2005; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                              </select>
                              <div class="invalid-feedback">
                                @error('year')
        
                                    {{  $message }}
                    
                                @enderror
                            </div>  
                        </div>

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

                <div class="form-group">
                    
                    <label for="login">Login</label>
                    <input type="text" value="{{ old('login') }}" id="login" name="login" class="form-control @error('login') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('login')

                            Musíte zadat login.
            
                        @enderror
                  
                    
                </div>

                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Registrovat zaměstnance</button>

                </div>
                
            </form>
       
    </div>

            </div></div></div></div>
@endsection