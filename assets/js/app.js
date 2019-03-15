var baseUrl = 'http://localhost/buscadorTest/';

$(document).ready( function () {
	
	$('#buscar').on('click',function(e){
		e.preventDefault();
		var keyword = $('#keyword').val();
		$('#results').html('<div class="col-md-12 text-center">Cargando...</div>');
		$.ajax({
			url: baseUrl + 'index.php/buscador/search',
			method: 'post',
			dataType: 'json',
			data : {
				'keyword' : keyword,
			},
			success: function (data) {
				$('#results').html('');
				console.log(data);
				$.each(data,function(index, value){
					var fechai = new Date(value.fecha_inicio);
					var fechaf = new Date(value.fecha_termino);
					var result = '<div class="col-md-12">'+
					'<div class="panel panel-default">'+
					  '<div class="panel-heading">'+
						'<h3 class="panel-title">'+value.titulo+'</h3>'+
					  '</div>'+
					  '<div class="panel-body">'+
						'<img class="img-dscto" src="'+value.imagen+'">'+
						value.descripcion +
						'<table class="table table-bordered">'+
							'<thead>'+
								'<tr>'+
									'<th>Precio</th>'+
									'<th>Vendidos</th>'+
									'<th>Fecha de Inicio</th>'+
									'<th>Fecha de Termino</th>'+
									'<th>Tags</th>'+
								'</tr>'+
							'</thead>'+
							'<tbody>'+
								'<tr>'+
									'<th>'+value.precio+'</th>'+
									'<td>'+value.vendidos+'</td>'+
									'<td>'+fechai.getDate()+'/'+fechai.getMonth()+'/'+fechai.getFullYear()+'</td>'+
									'<td>'+fechaf.getDate()+'/'+fechaf.getMonth()+'/'+fechaf.getFullYear()+'</td>'+
									'<td>'+value.tags+'</td>'+
								'</tr>'+
							'</tbody>'+
						'</table>'+
					  '</div>'+
					'</div></div>';
					$('#results').append(result);
				});
			}
		})	
	});

});