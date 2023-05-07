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
                                <a href="#">Eventos</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="main">Home</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="card-title col-6">Listado de procesos o eventos</div>
                            <div class="col-6 text-end">
                                <button class="btn btn-success" id="btn_create"><i class="fa-solid fa-pen"></i> Crear</button>
                                <a class="btn btn-info" href="<?php echo base_url(); ?>procesos/consultas"><i class="fa-solid fa-magnifying-glass-plus"></i> Consultar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_offer" class="table table-hover table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Objeto</th>
                                        <th>Moneda</th>
                                        <th>Presupuesto</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Estado</th>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear proceso / Evento participación cerrada <span id="txt_tit" class="fw-bold text-info"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Información básica</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cronograma-tab" data-bs-toggle="tab" data-bs-target="#cronograma" type="button" role="tab" aria-controls="cronograma" aria-selected="false">Cronograma</button>
                        </li>

                        <li class="nav-item tab-edit d-none" role="presentation">
                            <button class="nav-link" id="documento-tab" data-bs-toggle="tab" data-bs-target="#documento" type="button" role="tab" aria-controls="documento" aria-selected="false">Documentación petición de ofertas</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <input type="hidden" id="off_id">
                                        <input type="hidden" id="protuct_pro_id">
                                        <div class="col-md-6">
                                            <label for="off_obeject" class="form-label">Objeto <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="off_obeject">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txt_actividad" class="form-label">Actividad <span class="text-danger">*</span></label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="txt_actividad" aria-label="Actividad" aria-describedby="txt_actividad" readonly>
                                                <button class="btn btn-outline-secondary" type="button" id="btn_open"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="off_description" class="form-label">Descripción / Alcance</label>
                                            <textarea class="form-control" id="off_description" name="off_description" cols="30" rows="3">

                                            </textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="off_currency" class="form-label">Moneda</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text"><i class="fa-solid fa-list"></i></span>
                                                <select class="form-select" id="off_currency" aria-label="Moneda" aria-describedby="off_currency">
                                                    <option value="1">COP</option>
                                                    <option value="2">USD</option>
                                                    <option value="3">EUR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="off_amount" class="form-label">Presupuesto</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text"><i class="fa-solid fa-sack-dollar"></i></span>
                                                <input type="number" class="form-control" id="off_amount" aria-label="Presupuesto" aria-describedby="off_amount" id="off_amount">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="cronograma" role="tabpanel" aria-labelledby="cronograma-tab">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="off_start_date" class="form-label">Fecha Inicio <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="off_start_date">
                                </div>
                                <div class="col-md-3">
                                    <label for="off_start_time" class="form-label">Hora Inicio <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="off_start_time">
                                </div>

                                <div class="col-md-3">
                                    <label for="off_end_date" class="form-label">Fecha de Cierre <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="off_end_date">
                                </div>

                                <div class="col-md-3">
                                    <label for="off_end_time" class="form-label">Hora Cierre <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="off_end_time">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade tab-edit d-none" id="documento" role="tabpanel" aria-labelledby="documento-tab">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label for="doc_title" class="form-label">Titulo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="doc_title">
                                </div>
                                <div class="col-md-5">
                                    <label for="doc_content" class="form-label">Descripción <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="doc_content">
                                </div>
                                <div class="col-md-2 text-center">
                                    <label for="off_start_date" class="form-label">Agregar contenido </label>
                                    <button class="btn btn-info btn-md" id="btn_add_content"><i class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="tbl_contenido" class="table table-striped table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th class="w-75">Descripción</th>
                                            <th class="w-5 text-center">...</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_rowcontent">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn_save">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modal_prods" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content shadow-lg m-3 bg-body rounded">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Actividad</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive overflow-auto vh-90">
                        <table id="tbl_actividad" class="table table-hover table-bordered table-sm" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>COD</th>
                                    <th>Producto</th>
                                    <th>Clase</th>
                                    <th>Familia</th>
                                    <th>Segmento</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <?php
    include_once './src/Views/includes/footer.php';
    ?>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="<?php echo base_url(); ?>src/js/offer.js"></script>
</body>

</html>