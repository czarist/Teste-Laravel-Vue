<form action="{{ route('financeiro.relatorios.get') }}" method="GET">
    <div class="row">
        <div class="input-group input-group-sm mb-3 col-3 col-md-3 col-xl-3">
            <div class="input-group-prepend w-100" >
                <label class="input-group-text" for="tipo">Região</label>
                <select class="form-control form-control-sm select2-init " name="tipo">
                    <option selected="selected" value="0">Selcione uma regiao</option>
                    <option value="6">Sul</option>
                    <option value="7">Nordeste</option>
                    <option value="8">Sudeste</option>
                    <option value="9">Centro-Oeste</option>
                    <option value="10">Norte</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> <b>Filtrar</b></button>
            <button type="button" onclick="event.preventDefault(); document.getElementById('excel-form').submit();" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Excel
            </button>
        </div>
    </div>
</form>
