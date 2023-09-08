<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard | Adminlte' }}</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/dist/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('Auth-Panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <style>
        .datatable-header {
            display: flex;
            justify-content: space-between;
        }

        .datatable-footer {
            display: flex;
            justify-content: space-between;
        }

        /* Front button responsive Datatable centralizado */
        /* Button responsive Datatable */
        table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
            position: relative;
            top: 0px;
            left: 0px;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child,
        table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child {
            padding-left: 0px;
        }

        /* Front button colvis Datatable green */
        /* Button colvis Datatable green in active */
        button.dt-button.active {
            color: #fff !important;
            background: #28a745 !important;
            border-color: #28a745 !important;
            box-shadow: none !important;
        }

        /* Arrow button colvis */
        .dt-down-arrow {
            margin-left: 5px !important;
        }

        /* Active de nav-legacy */
        /* nav-legacy li.active */
        [class*=sidebar-dark] .nav-legacy .nav-treeview>.nav-item>.nav-link.active,
        [class*=sidebar-dark] .nav-legacy .nav-treeview>.nav-item>.nav-link:focus,
        [class*=sidebar-dark] .nav-legacy .nav-treeview>.nav-item>.nav-link:hover {
            border-left: 3px solid !important;
        }

        [class*=sidebar-dark] .nav-legacy .nav-treeview>.nav-item>.nav-link,
        [class*=sidebar-dark] .nav-legacy .nav-treeview>.nav-item>.nav-link:focus {
            border-left: 3px solid !important;
            border-color: #343a40 !important;
        }

        .sidebar-mini .nav-legacy>.nav-item .nav-link.active .nav-icon,
        .sidebar-mini-md .nav-legacy>.nav-item .nav-link.active .nav-icon {
            margin-left: .2rem;
        }

        .sidebar-mini .nav-legacy>.nav-item .nav-link .nav-icon,
        .sidebar-mini-md .nav-legacy>.nav-item .nav-link .nav-icon {
            margin-left: .2rem;
        }

        /* Solução para abertura por cima de toasts de mensagem */
        .toasts-top-right.fixed {
            position: fixed;
            z-index: 10000 !important;
            top: 10px;
            right: 10px;
        }
    </style>

    @yield('headLocal')
</head>
