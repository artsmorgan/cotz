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

function convertToList(obj){
	var html = '';
	var options =  obj.map(function(x){
		return {
			id: x.id,
			value: x.firstname + ' ' + x.lastname
		}
	})

	for(var i = 0; i < options.length; i++){
		html += '<option value="'+options[i]['id']+'">'+ options[i]['value'] +'</option>'
	}

	return html;

}

$(document).ready(function(){
	parent.iframeLoaded();
	
	var table = $('#table').DataTable({
    	paging: false,
    	data:[],
    	language: {
	      "emptyTable": "No hay cotizaciones para mostrar"
	    },
	    columnDefs: [
	      {
	         targets: '_all',
	         defaultContent: '<i class="fas fa-times"></i>'
	      }
	   ],
	   "scrollY": 325,
    	columns: [
                { "data": "id_sort" ,
                	render : function ( data, type, row, meta ) {
                		// console.log('data',data);
		              return type === 'display'  ?
		                '<input class="input-select" type="checkbox" value="'+data+'" />' :
		                data;
		            }
             	},
                { "data": "no_cotizacion" },
                { "data": "name" },
                // { "data": "username" },
                { "data": "marca" },
                { "data": "fase" },
                { "data": "fecha_cotizacion" },
                // { "data": "fecha_creacion" }
		    ],
		    rowCallback: function (row, data) {},
		    filter: false,
		    info: false,
		    ordering: false,
		    processing: true,
		    retrieve: true    ,
		    bAutoWidth: false  , 
	});	

 //    $('body').on('click','.gotocot',function(e){
 //    	parent.iframeLoaded();
 //    	e.preventDefault();
 //    	$('#message-load').html('Redireccionando, favor espere.')
 //    	$('#loadingModal').modal({backdrop: 'static', keyboard: false});
 //    	var id = $(this).attr('id');
 //    	var location = "cotz_update.php?u="+_username+"&advancefilters=1&cotId="+id;
 //    	// console.log('location', location);
 //    	window.location.href = location
 //    })
	

	$('#filter-now').on('click', function(e){
		var data = $('#filters-form').serialize();
		console.log('Buscar',data)
		// var formDataObj = deserializeData(data);
		
		var btn = $(this);
		btn.html('<i class="fas fa-cog fa-spin"></i>');

		var custom_url = 'services/cotz.php?action=custom_filter_merge';
		
		$('#selectAll').attr('disabled',true);
		$('#labelForSelectAll').addClass('muted');

		$('#companyHidden').val('');
		$('#newCompany').val('');
		$('#newContact').html(' <option value="">-</option>').prop('disabled', true).select2();
		$("#newVendedor").select2("val", "");
		
		var jqxhr = $.post( custom_url, data , function() {})
		  .done(function(data) {	
		  	// console.log('data',data)    
		    if(data)
		    	data = JSON.parse(data);
		    // console.log('data parse',data)

		    table.clear().draw();
            table.rows.add(data).draw();
            btn.html('Buscar');
            parent.iframeLoaded();
            $('#selectAll').attr('disabled',false);
            $('#labelForSelectAll').removeClass('muted');
		  })
		  .fail(function(error) {
		    console.log( "error", error );
		  })
		  
	});

	$('#noparent-btn').on('click', function(e){
		
		var btn = $(this);
		btn.html('<i class="fas fa-cog fa-spin"></i>');

		var custom_url = 'services/cotz.php?action=custom_filter_no_parent';
		
		$('#selectAll').attr('disabled',true);
		$('#labelForSelectAll').addClass('muted');
		
		var jqxhr = $.post( custom_url, {} , function() {})
		  .done(function(data) {	    		    
		    if(data)
		    	data = JSON.parse(data);
		    table.clear().draw();
            table.rows.add(data).draw();
            btn.html('Buscar sin Compañia');
            parent.iframeLoaded();
            $('#selectAll').attr('disabled',false);
            $('#labelForSelectAll').removeClass('muted');
		  })
		  .fail(function(error) {
		    console.log( "error", error );
		  })
		  
	});


	$("body").on('change','.input-select',function(){
		// conosole.log('checked')
		if($(this).is(":checked")){
		    $(this).parent().parent().addClass("selected-bg"); 
		    $('#modify').prop('disabled',false)
		}
		else{
		    $(this).parent().parent().removeClass("selected-bg");
		    $('#modify').prop('disabled',true)  
		} 
	});

	$("body").on('change','#selectAll',function(){
		// conosole.log('checked')
		if($(this).is(":checked")){			
			$('.input-select').prop('checked', true)	
		    $('.input-select').parent().parent().addClass("selected-bg");
		    $('#modify').prop('disabled',false);
		    
		}
		else{
			$('.input-select').prop('checked', false)
		    $('.input-select').parent().parent().removeClass("selected-bg");  
		    $('#modify').prop('disabled',true)
		} 
	});

	$("body").on('click','#modify',function(){
		//validate()
		var newCompany = $('#companyHidden').val();
		var newVendedor = $('#newVendedor').val();
		var newContact = $('#newContact').val();

		if(newCompany != '' &&  newContact == ''){			
			Swal.fire('Debe Especificar un Nuevo contacto')
			return false;
		}

		if(newCompany == '' && newContact == '' && newVendedor == ''){
			Swal.fire('Seleccionar una nueva compañia o un nuevo vendedor')	
			return false;
		}

		Swal.fire({
		  title: 'Esta seguro de asignar estas cotizaciones?',
		  text: "Esta Acción es irreverseible!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si!',
		  cancelButtonText: 'Cancelar'
		})
		.then(function(result){
		  if(result && result.value){

		  	$('#message-load').html('Actualizando las cotizaciones...' )
            $('#loadingModal').modal({backdrop: 'static', keyboard: false});

		  	var selected = [];
			$('.input-select:checked').each(function() {
			    selected.push($(this).attr('value'));
			});

			var data = {
				vendedorId: $('#newVendedor').val(),
				contactId: $('#newContact').val(),
				companyId: $('#companyHidden').val(),
				list: JSON.stringify(selected)

			}
			var custom_url = 'services/cotz.php?action=update_cotheader';
            var jqxhr = $.post( custom_url, data , function() {})
			  .done(function(data) {	    
			  	console.log('data',data)
			  	$('#filter-now').click();
			    $('#loadingModal').modal('hide');
			  })
			  .fail(function(error) {
			    console.log( "error", error );
			  })
		  }
		})
	})

	$("#companiaInput").autocomplete({
          minLength: 2,
          delay: 800,
          classes:{
            'ui-autocomplete': 'customAutocomplete'
          },
          source: function(request, response) {
              $.ajax({
                  url: "services/cotz.php",
                  data: { term: request.term,action: 'term_company' },
                  dataType: "json",
                  type: "POST",
                  success: function(data){
                    //console.log(data);
                     var result = $.map(data, function(item){
                    // console.log(item);
                    return {
                              label: item.name,
                              value: item.name,
                              id: item.id,
                              desc: item.description,
                              phone: item.officephone,
                              website: item.website
                          }
                      });
                      response(result);
                  }
              });
          },
          // Inputs customer data into forms.
          select: function(event, ui){
            //do it here
            $( "#companiaInput" ).text( ui.label );
          }
      })
      .autocomplete( "instance" )._renderItem = function( ul, item ) {
      // console.log(item);
        var desc = (item.desc==null || item.desc == '') ? "-" : item.desc;
        return $( "<li>" )
          .append( "<div>" + item.label + "<br> <strong>Telefono:</strong> " + item.phone + "</div>" )
          .appendTo( ul );
      };

      $("#newCompany").autocomplete({
          minLength: 2,
          delay: 800,
          position: { my : "right top", at: "right bottom" },
          classes:{
            'ui-autocomplete': 'customAutocomplete'
          },
          source: function(request, response) {
              $.ajax({
                  url: "services/cotz.php",
                  data: { term: request.term,action: 'term_company' },
                  dataType: "json",
                  type: "POST",
                  success: function(data){
                    //console.log(data);
                     var result = $.map(data, function(item){
                    // console.log(item);
                    return {
                              label: item.name,
                              value: item.name,
                              id: item.id,
                              desc: item.description,
                              phone: item.officephone,
                              website: item.website
                          }
                      });
                      response(result);
                  }
              });
          },
          // Inputs customer data into forms.
          select: function(event, ui){
            console.log('ui',ui);
            $( "#newCompany" ).text( ui.label );
            $( "#companyHidden" ).val( ui.item.id );
            $('#message-load').html('Cargando los Contactos de <br> ' + ui.item.label )
            $('#loadingModal').modal({backdrop: 'static', keyboard: false});

            var custom_url = 'services/cotz.php?action=get_usersAccount';
            var jqxhr = $.post( custom_url, {acc_id:ui.item.id} , function() {})
			  .done(function(data) {	    
			    if(data)
		    		data = JSON.parse(data);

		    	if(data.result && data.ok){
		    		var dropdownList = convertToList(data.result);	
		    			
		    			$("#newContact").prop('disabled',false).html(dropdownList).select2();
		    	}else{
		    		console.log('un error ha ocurrido cargando los contactos')
		    	}
		    	

			    $('#loadingModal').modal('hide');
			  })
			  .fail(function(error) {
			    console.log( "error", error );
			  })

          }
      })
      .autocomplete( "instance" )._renderItem = function( ul, item ) {
      // console.log(item);
        var desc = (item.desc==null || item.desc == '') ? "-" : item.desc;
        return $( "<li>" )
          .append( "<div>" + item.label + "<br> <strong>Telefono:</strong> " + item.phone + "</div>" )
          .appendTo( ul );
      };

})