@extends('layouts.navigation')

@section('content')
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header text-center">Přidat dodavatele</div>

            <div class="card-body"> 
        
            <form action="{{ route('producers.store') }}" method="POST">
                @csrf

                <div class="form-group ">
                   
                    <label for="name">Název</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('name')

                            Musíte zadat název dodavatele.
            
                        @enderror
                    </div>
                </div>

                

                <div class="form-group ">

                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('email')

                            Musíte zadat email dodavatele.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                   
                    <label for="phone">Telefon</label>
                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('phone')

                            Musíte zadat telefon dodavatele.
            
                        @enderror
                    </div>
                </div>

             
                <div class="form-group ">
                    
                    <label for="address">Adresa</label>
                    <input type="text" id="address" name="address" class="form-control @error('phone') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('address')

                            Musíte zadat adresu dodavatele.
            
                        @enderror
                    </div>
                </div>
                        
                    
        
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat dodavatele</button>

                </div>

            </form>

            </div>
        </div>
    </div>
</div>
</div>

@endsection