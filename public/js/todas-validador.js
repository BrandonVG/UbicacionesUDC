let ubicaciones = [];
let table = {};
let rowToDelete;

//Indefinidas (-1), aceptadas (1) y canceladas (0)
function sortUbicacionesByAceptado(arrayUbica) {
  const sortOrder = ['-1', '1', '0'];
  ubicaciones.sort((a, b) => {
    return sortOrder.indexOf(a.aceptado) - sortOrder.indexOf(b.aceptado);
  });
}

$(window).load(() => {

  table = $('#table').DataTable({
    "iDisplayLength": 10,
    "lengthMenu": [[10, 25, 50], [10, 25, 50]],
    "order": [],
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
  });

  window.axios.get('/ubicaciones/api/ubicacion?validador=2&todas=true')
    .then(async res => {
        ubicaciones = res.data;
        await sortUbicacionesByAceptado(ubicaciones);

        ubicaciones.forEach((ubicacion,index) => {
          console.log(ubicacion.aceptado);
          let aceptado = '';
          let opciones = 
            `<div class="btn-group-vertical btn-group-sm" role="toolbar">
              <button class="btn btn-info ver" value="${index}">
              <i class="fa fa-eye" aria-hidden="true"></i>
              <span>&nbsp;${ubicacion.aceptado == 1 ? 'Ver' : 'Previsualizar'}
                <span></button>
              <button class="btn btn-danger borrar" value="${index}">
              <i class="fa fa-trash-alt" aria-hidden="true"></i>
              <span>&nbsp;Eliminar<span></button>
            </div>`;

          switch (parseInt(ubicacion.aceptado)) {
            case -1: aceptado='<i class="fa fa-minus-square-o text-secondary"'+
              ' aria-hidden="true"></i>&nbsp;Pendiente';break;
            case 0: aceptado = '<i class="fa fa-times-circle-o text-danger"'+
              ' aria-hidden="true"></i>&nbsp;Rechazada';break;
            case 1: aceptado = '<i class="fa fa-check-circle-o text-success"'+
              ' aria-hidden="true"></i>&nbsp;Aceptada';break;
            default: aceptado = 'Corrompido';
          }

          let visible = "";
          if(ubicacion.aceptado == 1) {
            visible = ubicacion.visible == 1 
            ? ' <input class="form-check-input visible"'+
              ' type="checkbox" value="'+ ubicacion.id +'" checked>&nbsp;' + 
              ' <label class="form-check-label"><i class="fa fa-eye fa-3x ' + 
              ' text-info" aria-hidden="true" id="lblEye'+ ubicacion.id +'"> '+
              '</i></label>'
            : '<input class="form-check-input visible" type="checkbox" '+
              'value="'+ ubicacion.id +'">&nbsp;' + 
              '<label class="form-check-label"><i class="fa fa-eye-slash '+
              'fa-3x text-secondary" aria-hidden="true" '+ 
              'id="lblEye'+ubicacion.id+'"></i></label>';
          }

          let clasificadores = ''
          let tags = ubicacion.clasificadores.split(' ')

          tags.forEach(tag => clasificadores += '<span class="label ' + 
            'label-primary">' + tag + '</span>&nbsp;');

          table.row.add([
            ubicacion.etiqueta,
            ubicacion.titulo,
            clasificadores,
            aceptado,
            visible,
            opciones
          ]);

          // console.log(ubicacion.id);
        });
        table.draw();
    })
    .catch(err => console.error(err))

  $("tbody").on('change', '.visible', function() {
    var id = $(this).val();
    var visible = $(this)[0].checked ? 1 : 0;
    window.axios.put('/ubicaciones/api/ubicacion?id=' + id + '&visible=' + visible)
        .then((res) => {
          changeEyeIcon(`lblEye${id}`, $(this)[0].checked);
        })
        .catch(err => console.error(err))
  });

  $('tbody').on('click', 'button.ver', function(){
    //Set index to btnRechazar
    let index = $(this).val();
    window.open('/ubicaciones/ver-ubicacion/' + ubicaciones[index].id);
    // alert(`Ver la ubicación: ${ubicaciones[index].etiqueta}`);
  });

  $('tbody').on('click', 'button.borrar', function() {
    let index = $(this).val();
    console.log(index);
    rowToDelete = $(this).parents('tr');
    $('#btnBorrar').val(index);
    $('#modalTitle').text('¿Estás seguro que quieres eliminar la ubicación "'+
      ubicaciones[index].etiqueta + '"');
    $('#modalBorrar').modal('show');
  });
})

$('#btnBorrar').on('click', (ev) => {
  let index = ev.currentTarget.value;
  console.table(ubicaciones[index]);  
  window.axios.delete('/ubicaciones/api/ubicacion?id=' + ubicaciones[index].id)
    .then(res => {
      console.log(res.data);
      table.
        row(rowToDelete )
        .remove()
        .draw();
    })
    .catch(err => console.log(err));

  $('#modalBorrar').modal('hide');
});

function changeEyeIcon(id, checked) {
  //Si se recibe verdadero es porque está en falso
  let faCurrentClass = checked ? 'fa-eye-slash text-secondary' 
    : 'fa-eye text-info';
  let newFaClass = !checked ? 'fa-eye-slash text-secondary' 
    : 'fa-eye text-info';

  $(`#${id}`).removeClass(faCurrentClass);
  $(`#${id}`).addClass(newFaClass);
}

$('#selectDependencias').on('change', function(ev) {
  var id = $(this).val();
  window.axios.get('/ubicaciones/api/ubicacion?validador=true&todas=true&admin=' + id)
    .then(async ({data}) => { 
      table.clear().draw();
      ubicaciones = [];

      ubicaciones = data;
      await sortUbicacionesByAceptado(ubicaciones);

      ubicaciones.forEach((ubicacion,index) => {
        console.log(ubicacion.aceptado);
        let aceptado = '';
        let opciones = 
          `<div class="btn-group-vertical btn-group-sm" role="toolbar">
            <button class="btn btn-info ver" value="${index}">
            <i class="fa fa-eye" aria-hidden="true"></i>
            <span>&nbsp;${ubicacion.aceptado == 1 ? 'Ver' : 'Previsualizar'}
              <span></button>
            <button class="btn btn-danger borrar" value="${index}">
            <i class="fa fa-trash-alt" aria-hidden="true"></i>
            <span>&nbsp;Eliminar<span></button>
          </div>`;

        switch (parseInt(ubicacion.aceptado)) {
          case -1: aceptado='<i class="fa fa-minus-square-o text-secondary"'+
            ' aria-hidden="true"></i>&nbsp;Pendiente';break;
          case 0: aceptado = '<i class="fa fa-times-circle-o text-danger"'+
            ' aria-hidden="true"></i>&nbsp;Rechazada';break;
          case 1: aceptado = '<i class="fa fa-check-circle-o text-success"'+
            ' aria-hidden="true"></i>&nbsp;Aceptada';break;
          default: aceptado = 'Corrompido';
        }

        let visible = "";
        if(ubicacion.aceptado == 1) {
          visible = ubicacion.visible == 1 
          ? ' <input class="form-check-input visible"'+
            ' type="checkbox" value="'+ ubicacion.id +'" checked>&nbsp;' + 
            ' <label class="form-check-label"><i class="fa fa-eye fa-3x ' + 
            ' text-info" aria-hidden="true" id="lblEye'+ ubicacion.id +'"> '+
            '</i></label>'
          : '<input class="form-check-input visible" type="checkbox" '+
            'value="'+ ubicacion.id +'">&nbsp;' + 
            '<label class="form-check-label"><i class="fa fa-eye-slash '+
            'fa-3x text-secondary" aria-hidden="true" '+ 
            'id="lblEye'+ubicacion.id+'"></i></label>';
        }

        let clasificadores = ''
        let tags = ubicacion.clasificadores.split(' ')

        tags.forEach(tag => clasificadores += '<span class="label ' + 
          'label-primary">' + tag + '</span>&nbsp;');

        table.row.add([
          ubicacion.etiqueta,
          ubicacion.titulo,
          clasificadores,
          aceptado,
          visible,
          opciones
        ]);
      });
      table.draw();
      $('#lblDependencia').text('Dependencia actual: ' + $('#lblDepen' + id).text());
    })
    .catch(err => console.log(err))
});