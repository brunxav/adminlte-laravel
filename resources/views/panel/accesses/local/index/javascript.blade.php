@section('javascriptLocal')
    <script src="{{ asset('Auth-Panel/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('Auth-Panel/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(function() {
            initDatatable();

            $(document).on('click', ".btn-add", function(e) {
                openModal(this, e, 'modal-lg');
            });

            $(document).on('click', ".btn-edit", function(e) {
                openModal(this, e, 'modal-lg');
            });

            $(document).on('click', ".btn-delete", function(e) {
                openModal(this, e, 'modal-lg');
            });

            $(document).on('click', "#btn-remover", function(e) {
                executeAll(this, e, 'modal-lg');
            });

            $(document).on('click', ".btn-remove", removeImage);
        });

        function removeImage() {
            event.preventDefault();
            var url = $(this).parent().find("img").data('url');
            var id = $(this).parent().find("img").data('id');
            var token = $(this).parent().find("img").data('token');

            var main = $(this);

            var confirm = window.confirm("Deseja remover a imagem ?");

            if (confirm) {
                $.ajax({
                    url: "{{ route('panel.users.removeImage') }}",
                    type: "post",
                    data: {
                        "id": id,
                        "_token": token
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            $(main).parent('div').html(
                                "<img width='100' src='{{ asset('/storage/avatars/default.png') }}' alt=''>"
                            );
                        }
                    }
                });
            }
        }

        function initDatatable() {
            tableManage.setName('#table');
            tableManage.setPerPage(10);
            tableManage.setColumnDefs([{
                "targets": 0,
                "orderable": false
            }]);
            tableManage.setOrder([[2, 'desc']]);
            tableManage.setColumns([{
                    data: 'responsive',
                    orderable: false,
                    searchable: false,
                    className: 'align-middle',
                },
                {
                    data: 'checkbox',
                    orderable: false,
                    searchable: false,
                    className: 'align-middle'
                },
                {
                    data: 'id',
                    orderable: true,
                    searchable: true,
                    className: 'align-middle'
                },
                {
                    data: 'name',
                    orderable: true,
                    searchable: true,
                    className: 'name align-middle'
                },
                {
                    data: 'created_at',
                    orderable: true,
                    searchable: true,
                    className: 'align-middle'
                }
            ]);
            tableManage.setButton();
            tableManage.setRoute('{{ route("panel.$routeCrud.loadDatatable") }}');
            tableManage.setLengthMenu(
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"]
            );
            // 'Bfrtip'
            tableManage.setPluginButtonsDom(
                '<"wrapper"<"datatable-header"Blfr><"datatable-scroll"t><"datatable-footer"ip>>');
            tableManage.setPluginButtons(
                [{
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Colunas',
                    }
                ],
            );
            tableManage.render();
            tableManage.filter(true, '#table', ['', 'Ações']);
        }
    </script>
@endsection
