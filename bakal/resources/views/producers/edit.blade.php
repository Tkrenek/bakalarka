@extends('layouts.navigation')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header text-center">Upravit dodavatele</div>

            <div class="card-body">
    <form action="{{ route('producers.update', $producer->id) }}" method="POST" >
        
        @method('PUT')
        @csrf
        
        <div class="form-group">
                            
            <label for="name">Jméno dodavatele</label>
            
            <input type="text" value="{{ $producer->name }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
            <div class="invalid-feedback">
                @error('name')

                    Musíte zadat jméno dodavatele.
    
                @enderror
            </div>
        </div>

        <div class="form-group ">
            
            <label for="email">Email dodavatele</label>
            
            <input type="text" value="{{ $producer->email }}" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
            <div class="invalid-feedback">
                @error('email')

                    Musíte zadat email dodavatele.
    
                @enderror
            </div>
        </div>

        <div class="form-group ">
            
            <label for="phone">Telefon dodavatele</label>
            
            <input type="text" value="{{ $producer->phone }}" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror">
            <div class="invalid-feedback">
                @error('phone')

                    Musíte zadat telefon dodavatele.
    
                @enderror
            </div>
        </div>

        <div class="form-group">
            
            <label for="address">Adresa dodavatele</label>
            
            <input type="text" value="{{ $producer->address }}" id="address" name="address" class="form-control @error('address') is-invalid @enderror">
            <div class="invalid-feedback">
                @error('address')

                    Musíte zadat adresu dodavatele.
    
                @enderror
            </div>
        </div>

        <div class="form-group">
            
            <label for="town">Město dodavatele</label>
            
            <input type="text" value="{{ $producer->town }}" id="town" name="town" class="form-control @error('town') is-invalid @enderror">
            <div class="invalid-feedback">
                @error('town')

                    Musíte zadat město dodavatele.
    
                @enderror
            </div>
        </div>

       
   
        <div class="d-flex justify-content-center p-3">
            <button type="submit" class="btn btn-primary">Upravit údaje</button>

        </div>
        </form>
       
            </div></div></div></div></div>
@endsection