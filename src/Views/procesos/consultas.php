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
                        <h1>Procesos</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Consultas</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="<?php echo base_url(); ?>procesos/listar">Atras</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="s_objeto" class="form-label">Objecto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="s_objeto">
                            </div>
                            <div class="col-md-6">
                                <label for="s_descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="s_descripcion">
                            </div>
                            <div class="col-md-6">
                                <label for="s_responsable" class="form-label">Responsable</label>
                                <input type="text" class="form-control" id="s_responsable">
                            </div>
                            <div class="col-md-6">
                                <label for="s_estado" class="form-label">Estado</label>
                                <select class="form-select" id="s_estado">
                                    <option value="0">Todo</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Publicado</option>
                                    <option value="3">Evaluación</option>
                                </select>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button class="btn btn-info" id="btn_search"><i class="fa-solid fa-search"></i> Buscar</button>
                                <button class="btn btn-danger" id="btn_empty"><i class="fa-solid fa-broom"></i></button>
                                <button class="btn btn-success" onclick="exportarPreins()"> <i class="fa-solid fa-file-excel"></i> Generar Excel</button>
                            </div>

                            <div class="card-title col-12">Listado de procesos o eventos</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_offer" class="table table-hover table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Objeto</th>
                                        <th>Descripción</th>                                        
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Estado</th>
                                        <th>Responsable</th>
                                        <th class="text-center">Acciones</th>
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

    <script src="<?php echo base_url(); ?>src/js/consultas.js"></script>
</body>

<script>
    function exportarPreins(){
        off_obeject = $("#s_objeto").val();
        off_description = $("#s_descripcion").val();
        user_usu_id = $("#s_responsable").val();
        off_status = $("#s_estado").val();

        window.open('../src/Controllers/ExportExcel.php?off_obeject='+off_obeject+'&off_description='+off_description+'&user_usu_id='+user_usu_id+'&off_status='+off_status,'_blank');
        return false;
    }
</script>

</html>