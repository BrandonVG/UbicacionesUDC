
'use strict';
var ubicaciones = [ ]
var table = { }
function mySQLTimespanToJSDate(dateStr) {
  const timespan = dateStr.split(" ");
  const date = timespan[0].split("-");
  const time = timespan[1].split(":");
  return new Date(date[0],(date[1]-1),date[2],time[0],time[1],time[2]);
}

/** templates */
function lblAceptada (aceptada) {
  switch (Number(aceptada)) {
    case -1: return 'Pendiente';
    case 0: return '<i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i>&nbsp;Rechazada';
    case 1: return '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>&nbsp;Aceptada';
  }
}

function lblVisible (visible) {
  if (visible == 1)
    return '<i class="fa fa-eye fa-3x text-info" aria-hidden="true"></i>';
  return '<i class="fa fa-eye-slash fa-3x text-secondary" aria-hidden="true"></i>';
}

function btnEditar (index, fechaEdicion, fechaAprobacion) {
  if (mySQLTimespanToJSDate(fechaEdicion) > mySQLTimespanToJSDate(fechaAprobacion)) {
    return '<button class="btn btn-info editar" value="' + index + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> Editar<span></button><button class="btn btn-primary enviar" value="' + index + '"><i class="fa fa-envelope-o" aria-hidden="true"></i><span> Enviar</span></button>';
  }
  return '<button class="btn btn-info editar" value="' + index + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> Editar<span></button>';
}

function tdOpciones (index, ubicacion, form=false) {
  console.log(ubicacion)
 if (ubicacion.estatus == 0) {
   if (!form)
     return btnEditar(index, ubicacion.fechaEdicion, ubicacion.fechaAprobacion);
   return btnEditar(index, ubicacion.fechaEdicion, ubicacion.fechaAprobacion) + 
     '<form action="/ubicaciones/'+ sitio +'/editar-ubicacion/' + ubicacion.id +'" method="POST" hidden><input type="text" id="inpPadre" name="padre"><button type="submit" id="btnRedirect'+ index +'"></button></form>';
 }
  return '<i class="fa fa-inbox text-primary" aria-hidden="true"></i>&nbsp;Enviada';
}

function editRow (index, ubicacion) {
  let clasificadores = ''
  let tags = ubicacion.clasificadores.split(' ')
  tags.forEach(function (tag) {
    clasificadores += '<span class="label label-primary">' + tag + '</span>&nbsp;'
  });
  table.row(index).data([
    ubicacion.etiqueta,
    ubicacion.titulo,
    clasificadores,
    lblVisible(ubicacion.visible),
    lblAceptada(ubicacion.aceptado),
    tdOpciones(index, ubicacion)
  ]).draw(true);
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

  window.axios.get('/ubicaciones/api/ubicacion?editor=2')
    .then(res => {
      ubicaciones = res.data
      ubicaciones.forEach(function (ubicacion,index) {
        let clasificadores = ''
        let tags = ubicacion.clasificadores.split(' ')
        tags.map(tag => clasificadores += '<span class="label label-primary">' + tag + '</span>&nbsp;')
        table.row.add([
          ubicacion.etiqueta,
          ubicacion.titulo,
          clasificadores,
          lblVisible(ubicacion.visible),
          lblAceptada(ubicacion.aceptado, ubicacion.estatus),
          tdOpciones(index, ubicacion, true)
        ]).draw()
      })
    })
    .catch(err => console.error(err))

    $('tbody').on('click', 'button.enviar', e => {  
      const index = e.currentTarget.value
      const ubicacion = ubicaciones[index]
      if (mySQLTimespanToJSDate(ubicacion.fechaEdicion) > mySQLTimespanToJSDate(ubicacion.fechaAprobacion)) {
        ubicacion.estatus = 1
        window.axios.put('/ubicaciones/api/ubicacion?id=' +ubicacion.id + '&estatus=1')
          .then(res => {
            console.log(res.data);
            ubicaciones[index] = res.data
            editRow(index,res.data)
          })
          .catch(err => console.error(err))
      } else
        alert('No has editado')
    })

    // Prueba
    $('tbody').on('click', 'button.editar', e => {
      const index = e.currentTarget.value
      const ubicacion = ubicaciones[index]
      window.location = '/ubicaciones/' + sitio +'/editar-ubicacion/' + ubicacion.id;
    })
})