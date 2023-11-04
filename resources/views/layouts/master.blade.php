<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
    {{-- BootStrap --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    {{-- BootStrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Select2 CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Calendar --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <style>
        .dropdown-menu {
            border-radius: 5px !important;
        }
        .dropdown-menu a:hover {
            background-color: rgba(217, 233, 206, 0.73)
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid rgb(85, 83, 83);
        }
        .btn {
            border-radius: 5px;
        }
        .select2-dropdown {
            z-index: 9999;
        }
        .modal {
            z-index: 9999;
        }
        .form-select{
            min-height: 45px;
            border-radius: 10px;
            border: 1px solid rgb(85, 83, 83);
        }
        #deleteBtn:hover {
            background-color: red;
            color: white;
        }
        #editBtn:hover {
            background-color: yellow;
        }
        .form-select{
            min-height: 45px;
            border-radius: 10px;
        }
        
        a .disabled {
            pointer-events: none; /* Disable click events */
            color: #999; /* Change the text color to a grayed-out version */
            text-decoration: none; /* Remove underline */
        }
    </style>
</head>
<body style="background-color: #e3e3e3;">
    <div class="container-scroller">
        @yield('navigation')
        <div class="container-scroller">
            @include('layouts.inc.admin.navbar')
            <div class="container-fluid page-body-wrapper">
                @include('layouts.inc.admin.slidebar')
                <div class="main-panel">
                    <div class="content-wrapper">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert" id="alertSuccess">
                                {{session('success')}} 
                                <a href="" role="button" id="closeAlertSuccess">
                                    <i class="bi bi-x-lg" style="color: red; float:right"></i>
                                </a>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert" id="alertDanger">
                                {{session('error')}}
                                <a href="" role="button" id="closeAlertDanger">
                                    <i class="bi bi-x-lg" style="color: red ;float: right"></i>
                                </a>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        {{-- Jquery --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        {{-- Select2 --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
        {{-- Date picker --}}
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        @yield('script')
        <script>
            $('#closeAlertSuccess').click(function (e) { 
                e.preventDefault();
                $('#alertSuccess').addClass('d-none');
            });
        </script>
    </div>
</body>
</html>