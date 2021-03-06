function deserializeData(data){

	var map = {};

	$.each(data.split("&"), function () {
        var nv = this.split("="),
            n = decodeURIComponent(nv[0]),
            v = nv.length > 1 ? decodeURIComponent(nv[1]) : null;
        if (!(n in map)) {
            map[n] = "";
        }
        map[n] = v;
    })

    return map;
}

function gotoList(username){
    window.location.href = "index.php?u="+username;
    parent.iframeLoaded();
}

function gotoMerge(username){
    window.location.href = "merge.php?u="+username;
    parent.iframeLoaded();
}

$(document).ready(function(){
	$('#loadingModal').modal({backdrop: 'static', keyboard: false});

	var cookies = Cookies.getJSON('filters');
	// console.log('cookies', cookies);


    var table = $('#table').DataTable({
    	paging: false,
    	data:[],
    	columns: [
                { "data": "id_sort" ,
                	render : function ( data, type, row, meta ) {
                		// console.log('data',data);
		              return type === 'display'  ?
		                '<a href="#" class="gotocot" id="'+data+'"><i class="far fa-edit"></i></a>' :
		                data;
		            }
             	},
                { "data": "id" },
                { "data": "no_cotizacion" },
                { "data": "name" },
                { "data": "username" },
                { "data": "marca" },
                { "data": "fase" },
                { "data": "moneda" },
                { "data": "total" },
                { "data": "fecha_cotizacion" },
                { "data": "fecha_creacion" }
		    ],
	    rowCallback: function (row, data) {},
	    // filter: false,
	    info: false,
	    searching: false,
	    // ordering: false,
	    processing: true,
	    retrieve: true    ,
	    bAutoWidth: false  , 
	    dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print'
        ]
	});	

    $('body').on('click','.gotocot',function(e){
    	parent.iframeLoaded();
    	e.preventDefault();
    	$('#message-load').html('Redireccionando, favor espere.')
    	$('#loadingModal').modal({backdrop: 'static', keyboard: false});
    	var id = $(this).attr('id');
    	var location = "cotz_update.php?u="+_username+"&advancefilters=1&cotId="+id;
    	// console.log('location', location);
    	window.location.href = location
    })
	

	$('#filter-now').on('click', function(e){
		parent.iframeLoaded();

		Cookies.remove('filters');
		var data = $('#filters-form').serialize();
		var formDataObj = deserializeData(data);
		

		Cookies.set('filters', formDataObj);
		
		var btn = $(this);
		btn.html('<i class="fas fa-cog fa-spin"></i>');

		var custom_url = 'services/cotz.php?action=custom_filter';
		
		
		
		var jqxhr = $.post( custom_url, data , function() {
		  
		})
		  .done(function(data) {		    
		    if(data){
		    	try{
		    		data = JSON.parse(data);
		    		table.clear().draw();
			        table.rows.add(data).draw();
			        
		    	}catch(e){
		    		console.log('error filtros avanzados',e);
		    		alert('debe seleccionar aunque sea un filtro')
		    	}
		    	btn.html('Filtrar Cotizaciones');
		        $('#loadingModal').modal('hide');
		    	
		    }
		    
            parent.iframeLoaded();
		  })
		  .fail(function(error) {
		    console.log( "error", error );
		  })
		  
	});

	if(cookies){
		parent.iframeLoaded();
		if(cookies.cliente){
			cookies.cliente = cookies.cliente.replace(/\+/g,' ')			
		}
		if(cookies.marcas){
			cookies.marcas = cookies.marcas.replace(/\+/g,' ')			
		}

		$('#vendedor').val(cookies.vendedor).trigger('change');
		$('#fase').val(cookies.fase).trigger('change');
		$('#marcas').val(cookies.marcas).trigger('change');
		$('#moneda').val(cookies.moneda).trigger('change');
		$('#precioUnitario1').val(cookies.monto);
		$('#companiaInput').val(cookies.cliente).trigger('change');
		$('#datepicker_from').val(cookies.desde);
		$('#datepicker_to').val(cookies.hasta);
		$('#no_cotizacion').val(cookies.no_cotizacion);
		
		$('#filter-now').trigger("click");


	}else{
		$('#loadingModal').modal('hide');
	}

})