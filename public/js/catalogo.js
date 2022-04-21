'use strict';
var catalogo = [ ];
var table = { };

function setError (error, action = 2) {
  const actionClass = error ? 'addClass' : 'removeClass'
  $('#formObjeto')[actionClass]('has-danger')
  $('#newNombre')[actionClass]('form-control-danger')
  if (action == 0)
    $('#errorVacio').attr('hidden',!error)
  else if (action == 1)
    $('#errorRepetido').attr('hidden',!error)
  else {
    $('#errorVacio').attr('hidden',!error)
    $('#errorRepetido').attr('hidden',!error)
  }
}

$(window).load(function () {
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
  });

  window.axios.get('/ubicaciones/api/' + window.api).then(function (res) {
    catalogo = res.data;
    catalogo.forEach(function (objeto,index) {
      table.row.add([
        objeto.nombre,
        objeto.estatus == 1 ? '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>&nbsp;Activo' : '<i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i>&nbsp;Inactivo',
        `<button class="btn btn-primary editar" value="${index}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> Editar<span></button>${objeto.estatus == 1 ? '<button class="btn btn-danger desactivar" value="' + index + '"><i class="fa fa-times" aria-hidden="true"></i><span> Desactivar</span></button>' : '<button class="btn btn-success activar" value="' + index + '"><i class="fa fa-check" aria-hidden="true"></i><span> Activar</span></button>'}`
      ]).draw()
    })
  }).catch(function (err) {
    console.error(err);
  });

  $('#newNombre').on('click', e => setError(false));

  // Agraga envento que lanza modal a los botones de editar
  $('tbody').on('click', 'button.editar', function (e) {
    const index = e.currentTarget.value
    // El botton de enviar le estable el value igual al indice del elemento a editar
    $('#btnEnviar').val(index)
    $('#newNombre').val(catalogo[index].nombre)
    $('#modalEditar').modal('show')
  });

  $('tbody').on('click', 'button.desactivar', function (e) {
    const index = e.currentTarget.value
    const objeto = catalogo[index]
    objeto.estatus = 0
    window.axios.put(
      '/ubicaciones/api/' + window.api +'?id=' + objeto.id,
      objeto
    ).then(function (res) {
      catalogo[index] = res.data;
      table.row(index).data([
        res.data.nombre,
        res.data.estatus == 1 ? '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>&nbsp;Activo' : '<i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i>&nbsp;Inactivo',
        `<button class="btn btn-primary editar" value="${index}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> Editar<span></button>${res.data.estatus == 1 ? '<button class="btn btn-danger desactivar" value="' + index + '"><i class="fa fa-times" aria-hidden="true"></i><span> Desactivar</span></button>' : '<button class="btn btn-success activar" value="' + index + '"><i class="fa fa-check" aria-hidden="true"></i><span> Activar</span></button>'}`
      ])
      table.draw(true);
    }).catch(function (err) {
        console.error(err);
    });
  });

  $('#btnAgregar').on('click', function (e) {
    $('#modalEditar').modal('show');
  });

  $('tbody').on('click', 'button.activar', function (e) {
    const index = e.currentTarget.value;
    const objeto = catalogo[index];
    objeto.estatus = 1;
    window.axios.put(
      '/ubicaciones/api/'+ window.api +'?id='+ objeto.id,
      objeto
    ).then(function (res) {
      catalogo[index] = res.data;
      table.row(index).data([
        res.data.nombre,
        res.data.estatus == 1 ? '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>&nbsp;Activo' : '<i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i>&nbsp;Inactivo', `<button class="btn btn-primary editar" value="${index}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> Editar<span></button>${res.data.estatus == 1 ? '<button class="btn btn-danger desactivar" value="' + index + '"><i class="fa fa-times" aria-hidden="true"></i><span> Desactivar</span></button>' : '<button class="btn btn-success activar" value="' + index + '"><i class="fa fa-check" aria-hidden="true"></i><span>Activar</span></button>'}`
      ]);
      table.draw(true);
    }).catch(function (err) {
      console.error(err);
    })
  });

  // Cuando se cierra la modal regresa el value del botton de enviar a -1
  $('#modalEditar').on('hidden.bs.modal', function () {
    $('#btnEnviar').val('-1');
    $('#newNombre').val('');
    setError(false);
  });

  // Envia peticion por HTTP
  $('#btnEnviar').click(function() {
    let index = $(this).val();
    const nombre = $('#newNombre').val().trim();
    if (nombre != '') {
      if (index != -1) {
        const objeto = catalogo[index];
        if (objeto.nombre != nombre) {
          const foundIndex = catalogo.findIndex(function(e) {
            e.nombre.toLowerCase() == nombre.toLowerCase();
          });
          if (foundIndex == -1 || foundIndex == index) {
            objeto.nombre = nombre;
            window.axios.put(
              '/ubicaciones/api/'+ window.api+ '?id='+objeto.id,
              objeto
            ).then(function (res) {
              catalogo[index] = res.data;
              table.row(index).data([
                res.data.nombre,
                res.data.estatus == 1 ? '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>&nbsp;Activo' : '<i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i>&nbsp;Inactivo',`<button class="btn btn-primary editar" value="${index}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> Editar<span></button>${res.data.estatus == 1 ? '<button class="btn btn-danger desactivar" value="' + index + '"><i class="fa fa-times" aria-hidden="true"></i><span> Desactivar</span></button>' : '<button class="btn btn-success activar" value="' + index + '"><i class="fa fa-check" aria-hidden="true"></i><span> Activar</span></button>'}`
              ]);
              table.draw(true);
              $('#modalEditar').modal('hide');
            }).catch(function (err) {
              console.error(err);
            });
          } else 
            setError(true,1)
        } else 
          $('#modalEditar').modal('hide')
      } else {
        if (catalogo.findIndex(function (e) {
          e.nombre.toLowerCase() == nombre.toLowerCase()
        }) == -1) {
          window.axios.post(
            '/ubicaciones/api/'+ window.api,
            {nombre:nombre}
          ).then(function (res) {  
            index = catalogo.length;
            catalogo.push(res.data);
            table.row.add([
              res.data.nombre,
              res.data.estatus == 1 ? '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>&nbsp;Activo' : '<i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i>&nbsp;Inactivo',`<button class="btn btn-primary editar" value="${index}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> Editar<span></button>${res.data.estatus == 1 ? '<button class="btn btn-danger desactivar" value="' + index + '"><i class="fa fa-times" aria-hidden="true"></i><span> Desactivar</span></button>' : '<button class="btn btn-success activar" value="' + index + '"><i class="fa fa-check" aria-hidden="true"></i><span> Activar</span></button>'}`
            ]);
            table.draw(true);
          }).catch(function (err) {
            console.error(err);
          });
          $('#modalEditar').modal('hide');
        } else {
          setError(true,1);
        }
      }
    } else {
      setError(true,0)
    }
  });
});

$('#newNombre').keypress(function (ev) {
  if (ev.which == 13) {
    $('#btnEnviar').click(); 
  }
});
