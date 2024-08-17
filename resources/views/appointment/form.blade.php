<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="start" class="form-label">{{ __('Start') }}</label>
            <input type="text" name="start" class="form-control @error('start') is-invalid @enderror" value="{{ old('start', $appointment?->start) }}" id="start" placeholder="Start">
            {!! $errors->first('start', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="end" class="form-label">{{ __('End') }}</label>
            <input type="text" name="end" class="form-control @error('end') is-invalid @enderror" value="{{ old('end', $appointment?->end) }}" id="end" placeholder="End">
            {!! $errors->first('end', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">{{ __('Status') }}</label>
            <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $appointment?->status) }}" id="status" placeholder="Status">
            {!! $errors->first('status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="motive" class="form-label">{{ __('Motive') }}</label>
            <input type="text" name="motive" class="form-control @error('motive') is-invalid @enderror" value="{{ old('motive', $appointment?->motive) }}" id="motive" placeholder="Motive">
            {!! $errors->first('motive', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="details" class="form-label">{{ __('Details') }}</label>
            <input type="text" name="details" class="form-control @error('details') is-invalid @enderror" value="{{ old('details', $appointment?->details) }}" id="details" placeholder="Details">
            {!! $errors->first('details', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fk_id_client" class="form-label">{{ __('Fk Idclient') }}</label>
            <input type="text" name="fk_idClient" class="form-control @error('fk_idClient') is-invalid @enderror" value="{{ old('fk_idClient', $appointment?->fk_idClient) }}" id="fk_id_client" placeholder="Fk Idclient">
            {!! $errors->first('fk_idClient', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>