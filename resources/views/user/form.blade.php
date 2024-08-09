<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user?->name) }}" placeholder="Name">
            <input type="text" name="first_lastname" class="form-control @error('first_lastname') is-invalid @enderror" value="{{ old('first_lastname', $user?->first_lastname) }}" placeholder="First Lastname">
            <input type="text" name="second_lastname" class="form-control @error('second_lastname') is-invalid @enderror" value="{{ old('second_lastname', $user?->second_lastname) }}" placeholder="Second Lastname">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            {!! $errors->first('first_lastname', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-cake"></i></span>
            <select name="day" class="form-control @error('day') is-invalid @enderror">
                <option value="">{{__('Day')}}</option>
                @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}" {{ old('day', \Carbon\Carbon::parse($user->birthdate)->day) == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <select name="month" class="form-select @error('month') is-invalid @enderror">
                <option value="" disabled selected>{{ __('Month') }}</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ old('month', \Carbon\Carbon::parse($user->birthdate)->month) == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('M') }}
                    </option>
                @endforeach
            </select>
            <select name="year" class="form-select @error('year') is-invalid @enderror">
                <option value="" disabled selected>{{ __('Year') }}</option>
                @for ($y = now()->year; $y >= \Carbon\Carbon::now()->year - 100; $y--)
                    <option value="{{ $y }}" {{ old('year', \Carbon\Carbon::parse($user->birthdate)->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            {!! $errors->first('day', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            {!! $errors->first('month', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            {!! $errors->first('year', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user?->phone) }}" id="phone" placeholder="Phone">
            {!! $errors->first('phone', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user?->email) }}" id="email" placeholder="Email">
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <input type="hidden" name="status" value="update">
    </div>
</div>