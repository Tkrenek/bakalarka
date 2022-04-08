@extends('layouts.navigation')

@section('content')
  
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header text-center">Upravit profil admina</div>

            <div class="card-body">
            <form  action="{{ route('admins.update', $admin->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                    
                            <label for="name">Jméno</label>
                            
                            <input class="form-control @error('name') is-invalid @enderror"  type="text" value="{{ $admin->name }}" id="name" name="name">
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
                            <input type="text" class="form-control  @error('surname') is-invalid @enderror"  value="{{ $admin->surname }}" id="surname" name="surname" >
                            <div class="invalid-feedback">
                                @error('surname')
        
                                    Musíte zadat příjmení. 
                    
                                @enderror
                            </div>    
                        </div>

                    </div>

                </div>
                
 
                

                <div class="form-group">
                    
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $admin->email }}" name="email">
                    <div class="invalid-feedback">
                        @error('email')

                            Musíte zadat e-mail. 
            
                        @enderror
                    </div>     
                </div>

                <div class="form-group">
                   
                    <label for="phone">Telefonní číslo</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="text" id="phone"  name="phone" value="{{ $admin->phone }}">
                    <div class="invalid-feedback">
                        @error('phone')

                            Musíte zadat telefonní číslo.  
            
                        @enderror
                    </div>     
                </div>

                <div class="form-group">
                    <label for="birth_date">Datum narození</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
                    <div class="invalid-feedback">
                        @error('birth_date')

                            {{  $message }}
            
                        @enderror
                    </div>  
                </div>

          
                
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary ">Upravit admina</button>

                </div>
            </form>
        

            </div>

            </div>
        </div>
    </div>
</div>

@endsection