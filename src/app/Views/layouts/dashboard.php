<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Molonco | Dashboard" />
    <meta name="author" content="jantor,foca,pedro" />
    <meta name="X-CSRF-TOKEN" content="" />
    <title><?= $title ?? 'MOLONCO' ?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?= base_url('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/jqvmap/jqvmap.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css'); ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/daterangepicker/daterangepicker.css'); ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/summernote/summernote-bs4.min.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="stylesheet"
        href="<?= base_url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
    <link rel="stylesheet"
        href="<?= base_url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/toastr/toastr.min.css'); ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/select2/css/select2.min.css'); ?>">
    <link rel="stylesheet"
        href="<?= base_url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
    <!-- Trumbowyg -->
    <link rel="stylesheet" href="<?= base_url('plugins/trumbowyg/dist/ui/trumbowyg.min.css'); ?>">


    <!--begin::Script-->
    <!-- jQuery -->
    <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <!-- <script src="<? // base_url('adminlte/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script> -->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('adminlte/plugins/chart.js/Chart.min.js'); ?>"></script>
    <!-- Sparkline -->
    <script src="<?= base_url('adminlte/plugins/sparklines/sparkline.js'); ?>"></script>
    <!-- JQVMap -->
    <script src="<?= base_url('adminlte/plugins/jqvmap/jquery.vmap.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js'); ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= base_url('adminlte/plugins/jquery-knob/jquery.knob.min.js'); ?>"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url('adminlte/plugins/moment/moment.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>">
    </script>
    <!-- Summernote -->
    <script src="<?= base_url('adminlte/plugins/summernote/summernote-bs4.min.js'); ?>"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('adminlte/dist/js/adminlte.js'); ?>"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?= base_url('adminlte/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>">
    </script>
    <script src="<?= base_url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>">
    </script>
    <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/jszip/jszip.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
    <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>
    <!-- Toastr -->
    <script src="<?= base_url('adminlte/plugins/toastr/toastr.min.js'); ?>"></script>
    <!-- Select2 -->
    <script src="<?= base_url('adminlte/plugins/select2/js/select2.full.min.js'); ?>"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>">
    </script>
    <!-- Trumbowyg -->
    <script src="<?= base_url('plugins/trumbowyg/dist/trumbowyg.min.js'); ?>">
    </script>
    <!-- Import Trumbowyg plugins... -->
    <script src="<?= base_url('plugins/trumbowyg/dist/plugins/upload/trumbowyg.cleanpaste.min.js'); ?>"></script>
    <script src="<?= base_url('plugins/trumbowyg/dist/plugins/upload/trumbowyg.pasteimage.min.js'); ?>"></script>
    <!-- Number -->
    <script src="<?= base_url('plugins/number/jquery.number.min.js'); ?>"></script>
    <!-- Numeric -->
    <script src="<?= base_url('plugins/numeric/jquery.numeric.min.js'); ?>"></script>
    <!-- Loading Overlay -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>


    <!-- JavaScript Customs -->
    <script>
    const BASE_URL = `<?= base_url(); ?>`;
    </script>
    <script src="<?= base_url('js/global.js?v='.time()); ?>"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url('adminlte/dist/img/AdminLTELogo.png'); ?>"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!--begin::Header-->
        <?= view('layouts/header') ?>
        <!--end::Header-->

        <!--begin::Sidebar-->
        <?= view('layouts/sidebar') ?>
        <!--end::Sidebar-->

        <!-- Content Wrapper. Contains page content -->
        <?php 
            // $roleRouteModel = new \App\Models\RoleRouteModel();
            $currentRoute = uri_string(); // Obtiene la ruta actual sin dominio 
            
            // Obtener los permisos del usuario y organizarlos por controlador (para submenús)
            $menu = [];
            // $menu = $roleRouteModel
            //     ->select('cat_sys_routes.controller, cat_sys_routes.method, cat_sys_routes.name, cat_sys_routes.route, cat_sys_routes.icon, cat_sys_menus.name AS menu, cat_sys_menus.icon AS menu_icon')
            //     ->join('cat_sys_roles', 'cat_sys_roles.id = sys_role_routes.id_role')
            //     ->join('cat_sys_routes', 'cat_sys_routes.id = sys_role_routes.id_route')
            //     ->join('cat_sys_menus', 'cat_sys_menus.id = cat_sys_routes.id_menu')
            //     ->where('cat_sys_routes.route', $currentRoute)
            //     ->like('cat_sys_routes.method', 'index')
            //     ->orderBy('cat_sys_menus.order', 'ASC')
            //     ->first();
            $menu = menu();
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-capitalize">
                                <?= (!empty($menu['menu'])) ? $menu['menu'] : "SIN MENU" ; ?>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item text-capitalize"><a
                                        href="#"><?= (!empty($menu['name'])) ? $menu['name'] : "SIN MENU" ; ?></a></li>
                                <li class="breadcrumb-item text-capitalize active">
                                    <?= (!empty($menu['method'])) ? $menu['method'] : "SIN MENU" ; ?>
                                </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?= $body ?? '' ?>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <!--begin::Footer-->
        <?= view('layouts/footer') ?>
        <!--end::Footer-->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
</body>

</html>