<link rel="stylesheet" href="{{ asset('css/user/create.css') }}">
<!-- ########## NOMBRE COMPLETO ########## -->
<div class="input-group mb-3">
    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
    <!-- Nombre(s) -->
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('Name')}}"
        aria-label="{{__('Name')}}" aria-describedby="name" value="{{ old('name') }}">
    <!-- Primer apellido -->
    <input type="text" name="first_lastname" class="form-control @error('first_lastname') is-invalid @enderror"
        placeholder="{{__('First Last Name')}}" aria-label="{{__('First Last Name')}}" aria-describedby="firs_lastname"
        value="{{ old('first_lastname') }}">
    <!-- Segundo apellido -->
    <input type="text" name="second_lastname" class="form-control" placeholder="{{__('Second Last Name')}}"
        aria-label="{{__('Second Last Name')}}" aria-describedby="second_lastname" value="{{ old('second_lastname') }}">
    <!-- Mensajes de error -->
    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    @error('first_lastname')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<!-- ########## FECHA DE NACIMIENTO ############# -->
<div class="input-group mb-3">
    <span class="input-group-text"><i class="fa-solid fa-cake"></i></span>
    <!-- Día -->
    <select name="day" class="form-select @error('day') is-invalid @enderror">
        <option value="" disabled selected>{{__('Day')}}</option>
        @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" {{ old('day') == $i ? 'selected' : '' }}>{{ $i }}
            </option>
            @endfor
    </select>
    <!-- Mes -->
    <select name="month" class="form-select @error('month') is-invalid @enderror">
        <option value="" disabled selected>{{__('Month')}}</option>
        @foreach(range(1, 12) as $m)
        <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
            {{ DateTime::createFromFormat('!m', $m)->format('M') }}
        </option>
        @endforeach
    </select>
    <!-- Año -->
    <select name="year" class="form-select @error('year') is-invalid @enderror">
        <option value="" disabled selected>{{__('Year')}}</option>
        @for ($i = now()->year ; $i >= Carbon\Carbon::now()->year -100; $i--)
        <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    <!-- Mensajes de error -->
    @error('day')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    @error('month')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    @error('year')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<!-- ####### TELÉFONO ######## -->
<div class="input-group mb-3">
    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number"
        pattern="[0-9]{10}" title="{{__('Enter a phone number, Ex: 7771234567')}}"
        value="{{ old('phone') }}">
    @error('phone')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<!-- ############# CORREO ELECTRÓNICO ############# -->
<div class="input-group mb-3">
    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        placeholder="{{__('Email')}}" aria-label="{{__('Email')}}" aria-describedby="email"
        value="{{ old('email') }}">
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>