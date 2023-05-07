<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once './src/Views/includes/head.php';
    ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<body>
    <!-- SIDEBAR -->
    <?php
    include_once './src/Views/includes/menu.php';
    ?>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php
        include_once './src/Views/includes/navbar.php';
        ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="container-fluid">

                <div class="head-title">
                    <div class="left">
                        <h1>Usuario</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Listar</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="card-title col-12">Listado de usuarios</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_user" class="table table-hover table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    

    <?php
    include_once './src/Views/includes/footer.php';
    ?>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="<?php echo base_url(); ?>src/js/user.js"></script>
</body>

</html>