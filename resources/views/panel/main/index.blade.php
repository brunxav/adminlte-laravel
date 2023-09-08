@extends("$routeAmbient.template.index")

@section('content')
    <div class="content-wrapper">
        @include("$routeAmbient.$routeCrud.breadcrumb")

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @can('developer')
                        <div class="col-12">
                            Desenvolvedor
                        </div>
                    @endcan

                    @can('admin')
                        <div class="col-12">
                            Administrador
                        </div>
                    @endcan

                    @can('user')
                        <div class="col-12">
                            Usuário
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@includeIf("$routeAmbient.$routeCrud.local.index.head")
@includeIf("$routeAmbient.$routeCrud.local.index.javascript")
