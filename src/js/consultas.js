function init() {
    searchProcess();
}

$("#btn_search").click( function () {
    $('#tbl_offer').DataTable().ajax.reload();  
})

$("#btn_empty").click( function () {
    $("#s_objeto").val('');
    $("#s_descripcion").val('');
    $("#s_responsable").val(0);
    $("#s_estado").val(0);
    $('#tbl_offer').DataTable().ajax.reload();  
})

function searchProcess(){
    var dataTable = $('#tbl_offer').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "columnDefs": [{
                "orderable": false,
                "targets": 4
            },
            {
                "orderable": false,
                "targets": 0
            },
            {
                "className": "dt-center",
                "targets": 5
            }
        ],
        "retrieve": true,
        "ajax": {
            url: '../src/Controllers/OfferController.php?op=search_offer',
            type: "POST",
            dataType: "json",
            data: function(d) {
                d.off_obeject = $("#s_objeto").val();
                d.off_description = $("#s_descripcion").val();
                d.user_usu_id = $("#s_responsable").val();
                d.off_status = $("#s_estado").val();
            },
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10, //Por cada 10 registros hace una paginación
        /*"order": [
            [0, "desc"]
        ], //Ordenar (columna,orden) "desc, asc"*/

        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
            "searchPlaceholder": "Ingrese texto",
        } //cerrando language

    }).DataTable();
}


init();