<div class="modal-body">

    <h5 class="mb-3">Dados pessoais</h5>

    <div class="row d-flex align-items-center">
        <div class="form-group col-12">
            <div class="input-group">
                <input type="text" id="name" class="form-control" name="name" placeholder="Nome *"
                    value="{{ $item->name ?? old('name') }}" required>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {});
</script>
