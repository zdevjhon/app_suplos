function init() {
    listar();
    listarActividad();
}

$("#btn_save").click(function(){
    saveOffer();
})

$("#btn_create").click( function () {
    $('#exampleModal').modal({backdrop: 'static', keyboard: false})
    $('#exampleModal').modal('show');
})

$("#btn_open").click( function () {
    $('#modal_prods').modal({backdrop: 'static', keyboard: false})
    $('#modal_prods').modal('show');
})

$("#btn_add_content").click(function(e){
    addContent(e);
})

function eliminar(){
    $.toast({
        heading: 'SUPLOS',
        text: "EN DESARROLLO",
        position: 'top-center',
        stack: false,
        icon: 'warning'
    })
}

function saveOffer() {
    data = {
        off_id: $("#off_id").val(),
        off_obeject: $("#off_obeject").val(),
        off_description: $("#off_description").val(),
        off_currency: $("#off_currency").val(),
        off_amount: $("#off_amount").val(),
        off_start_date: $("#off_start_date").val(),
        off_start_time: $("#off_start_time").val(),
        off_end_date: $("#off_end_date").val(),
        off_end_time: $("#off_end_time").val(),
        off_status: $("#off_status").val(),
        user_usu_id: $("#user_usu_id").val(),
        protuct_pro_id: $("#protuct_pro_id").val(),
        offerer_ofr_id: $("#offerer_ofr_id").val()
    }
    $.ajax({
        url: '../src/Controllers/OfferController.php?op=create_update',
        type: 'POST',
        dataType: 'json',
        data: data,//{param1: 'value1'}
        success: function(datos)
        {   
            //https://kamranahmed.info/toast?utm_source=cdnjs&utm_medium=cdnjs_link&utm_campaign=cdnjs_library
            let icon = 'success';
            if(datos.status==1){
                icon = 'error';

            }else{
                //limpiar(); 
                $('#exampleModal').modal('hide');
				$('#tbl_offer').DataTable().ajax.reload();                 
            }
            $.toast({
                heading: 'SUPLOS',
                text: datos.msg,
                position: 'top-center',
                stack: false,
                icon: icon
            })
            
        }
    });
}

function listar(){
	tabla=$('#tbl_offer').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "columnDefs": [
        	{"orderable":false,"targets":6},
            {"sWidth": "10px", "targets": [1,2] },
        ],
		"ajax":{
			url: '../src/Controllers/OfferController.php?op=read_all',
			type : "get",
			dataType : "json",
			error: function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"responsive": true,
		"bInfo":true,
		"iDisplayLength": 10,//Por cada 10 registros hace una paginación
	    "order": [[ 0, "asc" ]],//Ordenar (columna,orden) "desc, asc"

	    "language": {
            "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
            "searchPlaceholder": "Ingrese texto",
        },//cerrando language
        createdRow: function (row,data) {
            $(row).addClass('text-xs font-weight-bold mb-0 text-center');
        },

	}).DataTable();
}

function listarActividad(){
	tabla=$('#tbl_actividad').dataTable(
	{
		'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "columnDefs": [
        	{"orderable":false,"targets":5},
            {"sWidth": "8px", "targets": [0,5] },
        ],
		"ajax":{
			url: '../src/Controllers/OfferController.php?op=read_all_actividad',
			type : "POST",
			dataType : "json",
			error: function(e){
				console.log(e.responseText);
			}
		},
        'columns': [
            { data: 'pro_id' },
            { data: 'pro_name' },
            { data: 'cat_name' },
            { data: 'fam_name' },
            { data: 'seg_name' },
            { data: 'action' },
        ],
		"bDestroy": true,
		"responsive": true,
		"bInfo":true,
		"iDisplayLength": 10,//Por cada 10 registros hace una paginación
	    "order": [[ 0, "asc" ]],//Ordenar (columna,orden) "desc, asc"

	    "language": {
            "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
            "searchPlaceholder": "Ingrese texto",
        },//cerrando language
        createdRow: function (row,data) {
            $(row).addClass('text-xs font-weight-bold mb-0 text-center');
        },

	}).DataTable();

    return false;
}

function mostrar(off_id) {
    $.post("../src/Controllers/OfferController.php?op=read",{off_id:off_id}, function(data, status)
    {        
        $(".tab-edit").removeClass("d-none");
        $('#exampleModal').modal({backdrop: 'static', keyboard: false})
        $('#exampleModal').modal('show');
        console.log(data)
        $("#off_id").val(data.off_id);
        $("#off_obeject").val(data.off_obeject);
        $("#off_description").val(data.off_description);
        $("#off_currency").val(data.off_currency);
        $("#off_amount").val(data.off_amount);
        $("#off_start_date").val(data.off_start_date);
        $("#off_start_time").val(data.off_start_time);
        $("#off_end_date").val(data.off_end_date);
        $("#off_end_time").val(data.off_end_time);
        $("#txt_tit").text("N° " + data.off_obeject + " - Edicion");
        seleccionar(data.protuct_pro_id)
        getContent(off_id)
    });
}

$("#exampleModal").on('hide.bs.modal', function() {
    $(".tab-edit").addClass("d-none");
    limpiar();
});

function limpiar(){
    $("#off_id").val('');
    $("#off_obeject").val('');
    $("#off_description").val('');
    $("#off_currency").val(1);
    $("#off_amount").val('');
    $("#off_start_date").val('');
    $("#off_start_time").val('');
    $("#off_end_date").val('');
    $("#off_end_time").val('');
    $("#protuct_pro_id").val('');
    $("#txt_actividad").val('');
    $("#txt_tit").text('');
}

function seleccionar(pro_id) {
    $.post("../src/Controllers/OfferController.php?op=get_offer",{pro_id:pro_id}, function(data, status)
    {        
        $("#protuct_pro_id").val(data.pro_id);
        $("#txt_actividad").val(data.pro_name);
        $('#modal_prods').modal('hide');
    });
}

function addContent(e) {
    e.preventDefault();
    let datos = {
        off_id: $("#off_id").val(),
        doc_title: $("#doc_title").val(),
        doc_content: $("#doc_content").val()
    }

    $.ajax({
        type: "post",
        url: "../src/Controllers/OfferController.php?op=add_content",
        data: datos,
        dataType: "json",
        success: function (data) {
            console.log(data);
            let icon = 'success';
            if(data.status==1){
                icon = 'error';

            }else{
                getContent($("#off_id").val());
            }
            $.toast({
                heading: 'SUPLOS',
                text: data.msg,
                position: 'top-center',
                stack: false,
                icon: icon
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Estado: " + textStatus + ", error: " + errorThrown);
        }
    });

    return false
}

function getContent(off_id) {
    let datos = {
        off_id:off_id
    }
    $.ajax({
        type: "post",
        url: "../src/Controllers/OfferController.php?op=get_content",
        data: datos,
        dataType: "json",
        success: function (data) {
            $("#tbl_rowcontent").html(data.html)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Estado: " + textStatus + ", error: " + errorThrown);
        }
    });

    return false;
}

init();