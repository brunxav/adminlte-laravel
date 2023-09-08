<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Duplicar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form id="formCreate{{ ucfirst($routeCrud) }}">
        @csrf

        @include("includes.forms.$routeCrud")

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary btn-submit">Criar</button>
        </div>
    </form>
</div>

<script>
    $("#formCreate{{ ucfirst($routeCrud) }}").on('submit', function(e) {
        e.preventDefault();

        $(".btn-submit").attr('disabled', true).text('Enviando...');

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'POST',
                url: '{{ $routeCrud }}/store/',
                data: $(this).serialize()
            })
            .done(function(data) {

                if (data.status == 400) {
                    Object.keys(data.errors).forEach((item) => {
                        // console.log(item + " = " + data.errors[item]);
                        $("#" + item).addClass('is-invalid');
                        toastMessage('fa fa-exclamation', 'bg-danger', 'Ops, houve um erro!', data
                            .errors[item]);
                    });

                    $(".btn-submit").removeAttr('disabled', true).text('Criar');
                } else if (data.status == 200) {
                    $(".modal").modal('hide');

                    $('#table').DataTable().draw(true);

                    toastMessage('fa fa-check', 'bg-success', 'Sucesso!', data.message);
                } else {
                    toastMessage('fa fa-exclamation', 'bg-warning', 'Atenção!',
                        'Tente novamente ou entre em contato com o administrador do sistema !');
                }

            })
            .fail(function() {
                console.log('fail');
            })
    });
</script>
