<div class="row">
    <div class="col-md-4 form-group">
        <label>Nombre Concepto*</label>
        <input type="text" name="nombre" value="{{ isset($concepto) ? $concepto->nombre : old('nombre') }}"
            class="form-control">
        @if ($errors->has('nombre'))
            <span class="invalid-feedback text-danger" style="display:block" role="alert">
                <strong>{{ $errors->first('nombre') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-md-4 form-group">
        <label>Costo*</label>
        <input type="number" step="0.01" name="costo"
            value="{{ isset($concepto) ? $concepto->costo : old('costo') }}" class="form-control">
        @if ($errors->has('costo'))
            <span class="invalid-feedback text-danger" style="display:block" role="alert">
                <strong>{{ $errors->first('costo') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-md-4 form-group">
        <label>Especialidad*</label>
        <select name="id_especialidad" class="form-control">
            <option value="">- Seleccione -</option>
            @foreach ($especialidades as $value)
                @php
                    $selected = '';
                    if (isset($concepto)) {
                        if ($concepto->id_especialidad == $value->id) {
                            $selected = 'selected';
                        }
                    }
                @endphp
                <option value="{{ $value->id }}" {{ $selected }}>{{ $value->especialidad }}</option>
            @endforeach
        </select>
        @if ($errors->has('id_especialidad'))
            <span class="invalid-feedback text-danger" style="display:block" role="alert">
                <strong>{{ $errors->first('id_especialidad') }}</strong>
            </span>
        @endif
    </div>
</div>
