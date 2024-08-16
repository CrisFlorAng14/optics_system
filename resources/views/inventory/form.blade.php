<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="type" class="form-label">{{ __('Type') }}</label>
            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $inventory?->type) }}" id="type" placeholder="Type">
            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fk_id_product" class="form-label">{{ __('Fk Idproduct') }}</label>
            <input type="text" name="fk_idProduct" class="form-control @error('fk_idProduct') is-invalid @enderror" value="{{ old('fk_idProduct', $inventory?->fk_idProduct) }}" id="fk_id_product" placeholder="Fk Idproduct">
            {!! $errors->first('fk_idProduct', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>