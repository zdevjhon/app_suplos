
function listar(){
	tabla=$('#tbl_user').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
		"ajax":{
			url: '../src/Controllers/UserController.php?op=read_all',
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

listar()
