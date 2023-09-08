<div class="modal-body">

    <h5 class="mb-3">Dados pessoais</h5>

    <div class="row d-flex align-items-center">
        <div class="form-group col-12 col-md-6">
            <div class="input-group">
                <input type="file" id="photo" name="photo">
            </div>
        </div>

        @if ($item->photo)
            <div class="col-6">
                <div class="card">
                    <div class="card-body m-auto">
                        <img width="100" data-url="/user/removeImage/" data-id="{{ $item->id }}"
                            data-token={{ csrf_token() }} src="{{ env('APP_URL') }}/storage/{{ $item->photo }}"
                            alt="">
                        @if ($item->photo != 'avatars/default.png')
                            <button type="button" class="btn-remove" title="Remover">x</button>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-6">
                <div class="card">
                    <div class="card-body m-auto">
                        <img width="100" src="{{ env('APP_URL') }}/storage/avatars/not-image.png"
                            alt="">
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group col-12 {{ $item->photo ? 'col-md-12' : 'col-md-6' }}">
            <div class="input-group">
                <input type="text" id="name" class="form-control" name="name" placeholder="Nome *"
                    value="{{ $item->name ?? old('name') }}" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-12">
            <div class="input-group">
                <input type="email" id="email" class="form-control" name="email" placeholder="E-mail *"
                    value="{{ $item->email ?? old('email') }}" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-12 col-md-6">
            <input type="password" id="password" class="form-control" name="password" placeholder="Senha"
                autocomplete="off">
        </div>

        <div class="form-group col-12 col-md-6">
            <div class="input-group">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    placeholder="Confirmar senha" autocomplete="off">
            </div>
        </div>
    </div>
</div>

<script>
    function getFormData() {
        const formData = new FormData()

        formData.append('id', $("#id").val());
        formData.append('name', $("#name").val());
        formData.append('email', $("#email").val());
        formData.append('password', $("#password").val());
        formData.append('password_confirmation', $("#password_confirmation").val());

        if ($('#photo').length) {
            if (document.getElementById('photo').files.length) {
                formData.append('photo', document.getElementById('photo')
                    .files[0])
            }
        }

        return formData;
    }

    $(function() {});
</script>
