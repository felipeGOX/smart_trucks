@csrf
<div class="row">
    <div class="col-12">
        <div class="form-floating">
            <input type="text" placeholder="nombre" class="form-control" name="nombre"
                value="{{ isset($red) ? $red->nombre : old('nombre') }}">
            <label>Nombre</label>
        </div>
    </div>
</div>
