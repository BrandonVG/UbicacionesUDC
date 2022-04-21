'use strict';
//UPDATE ubicaciones SET estatus = 1, aceptado = -1, idSitio = 2 WHERE id > 0
let ubicaciones = [ ];
let table = { };
let toDeleteRow;

//Row on table index
function createOptionButton(type, index)  {
  let buttonClasses = '';
  let faClass = '';
  let text = '';

  switch(type) {
    case 'ver':
      buttonClasses = "primary previsualizar";
      faClass = "bullseye";
      text = 'Previsualizar';
      break;
    case 'rechazar':
      buttonClasses = "danger rechazar";
      faClass = "times";
      text = 'Rechazar';
      break;
    case 'aceptar':
      buttonClasses = "success aceptar";
      faClass = "check";
      text = 'Aceptar';
      break;
    default:
      console.error(`El tipo: ${type}`);
      return 0;
  }

  return `<button class="btn btn-${buttonClasses}" value="${index}">
        <i class="fa fa-${faClass}" aria-hidden="true"></i>
        <span>&nbsp;${text}<span></button>`;
}

$(window).load(() => {
  table = $('#table').DataTable({
    "iDisplayLength": 10,
    "lengthMenu": [[10, 25, 50], [10, 25, 50]],
    "language": {
    "lengthMenu": "_MENU_ Registros por p&aacute;gina",
    "zeroRecords": "Registros no encontrados",
    "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
    "infoEmpty": "Registros no disponibles",
    "infoFiltered": "(filtrado de _MAX_ registros totales)",
    "sSearch": "Buscar",
      "oPaginate": {
        "sLast": "Final",
        "sNext": "Siguiente",
        "sFirst": "Principio",
        "sPrevious": "Anterior"
      }
    } 
  })

  //Armar el query y la petición de acuerdo a las que puede ver y del sitio al que pertence
  window.axios.get("/ubicaciones/api/ubicacion?validador=" + Math.random())
    .then(res => {
        ubicaciones = res.data
        ubicaciones.forEach((ubicacion,index) => {
          let aceptado = ''
          let opciones = '<div class="btn-group-vertical btn-group-sm"'+
            ' role="toolbar">';
          opciones += createOptionButton('ver', index);
          opciones += createOptionButton('aceptar', index);
          opciones += createOptionButton('rechazar', index);
          opciones += '</div>';
       
          let clasificadores = ''
          let tags = ubicacion.clasificadores.split(' ')
          tags.forEach(tag => clasificadores += '<span class="label ' + 
            'label-primary">' + tag + '</span>&nbsp;');
          table.row.add([
            ubicacion.etiqueta,
            ubicacion.titulo,
            clasificadores,
            opciones
          ]);

          console.log(ubicacion.id);
        });
        table.draw();
    })
    .catch(err => console.error(err))

  $('tbody').on('click', 'button.previsualizar', function(){
    let index = $(this).val();
    window.open('/ubicaciones/ver-ubicacion/' + ubicaciones[index].id);
    // alert(`Ver la ubicación "${ubicaciones[index].etiqueta}"`);
  });

  $('tbody').on('click', 'button.rechazar', function(){
    //Set index to btnRechazar
    let index = $(this).val();
    toDeleteRow = $(this).parents('tr');
    $('#btnRechazar').val(index);
    $('#modalTitle').text("Rechazar ubicación '" + 
      ubicaciones[index].etiqueta + "'");
    $('#modalRechazar').modal('show');
  });

  $('tbody').on('click', 'button.aceptar', function(){
    let index = $(this).val();
    console.log(ubicaciones[index].id);

    window.axios.put('/ubicaciones/api/ubicacion?id=' + ubicaciones[index].id + '&aceptado=1')
        .then((res) => {
          table
            .row( $(this).parents('tr') )
            .remove()
            .draw();
          console.log(res.data);
        })
        .catch(err => console.error(err));
  });
})

$('#btnRechazar').on('click', function(){
  console.log('Modal rechazar');
  let index = $(this).val();
  let motivo = $('#txtMotivo').val().trim();
  if(motivo) {
    window.axios.put('/ubicaciones/api/ubicacion?id=' + ubicaciones[index].id + '&aceptado=0', {motivo: motivo})
        .then((res) => {
          table
            .row(toDeleteRow)
            .remove()
            .draw();
          console.log(res.data);
        })
        .catch(err => console.error(err));

    $('#modalRechazar').modal('hide');
  }
  else {
    alert("Ingresa un motivo");
  }
});

$('#selectDependencias').on('change', function(ev) {
  var id = $(this).val();
  console.log('ID: ', id);
  window.axios.get('/ubicaciones/api/ubicacion?validador=true&admin=' + id)
    .then(res => {
        table.clear().draw();
        ubicaciones = [];

        ubicaciones = res.data
        ubicaciones.forEach((ubicacion,index) => {
          let aceptado = ''
          let opciones = '<div class="btn-group-vertical btn-group-sm"'+
            ' role="toolbar">';
          opciones += createOptionButton('ver', index);
          opciones += createOptionButton('aceptar', index);
          opciones += createOptionButton('rechazar', index);
          opciones += '</div>';
       
          let clasificadores = ''
          let tags = ubicacion.clasificadores.split(' ')
          tags.forEach(tag => clasificadores += '<span class="label ' + 
            'label-primary">' + tag + '</span>&nbsp;');
          table.row.add([
            ubicacion.etiqueta,
            ubicacion.titulo,
            clasificadores,
            opciones
          ]);

        });
        table.draw();
        $('#lblDependencia').text('Dependencia actual: ' + $('#lblDepen' + id).text());
    })
    .catch(err => console.error(err))
});