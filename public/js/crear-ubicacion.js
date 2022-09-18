//Avenida Universidad 333, Las Víboras 28040 Colima, Col. Mexico
var udc = { lat: 19.24896284462921, lng: -103.6988353729248 };
var marker = {};
var editor;
var editorResumen;
var editorDetalles;
var lblDireccion = document.getElementById('lblDireccion');
var href = window.location.href;
var equipamiento = []; 
var actividades = []; 
var dirigido = []; 
var tipos = [];

var simpleCkeditorConfig = {
  language: 'es',
  extraplugins: '',
  toolbar: [
    ['Undo', 'Redo'],
    ['Bold', 'Italic', 'Strike'],
    ['NumberedList', 'BulletedList'],
    ['Cut', 'Copy', 'Paste']
  ],
  height: '12em'
}

var formatError = false;

function get(id) {return document.getElementById(id);}

var initMap = function() {
  var map = new window.google.maps.Map(document.getElementById('map'), {
    center: udc,
    zoom: 14
  })

  var geocoder = new google.maps.Geocoder;

  map.addListener('click', function(e) {
    marker.setMap(null);
    marker = new google.maps.Marker({
              position: e.latLng,
              map: map
            });

    //Get the address
    geocoder.geocode({'location': e.latLng}, (results, status) => {
      if (status === 'OK') {
        if (results[0]) {
          console.log(results[0].formatted_address);
          lblDireccion.innerHTML = results[0].formatted_address;
        }
        else 
          lblDireccion.innerHTML = 'Hubo un problema al buscar la dirección';
      } 
      else 
        lblDireccion.innerHTML = 'Hubo un problema al buscar la dirección';
    });

    $('#txtLatitud').val(e.latLng.lat);
    $('#txtLongitud').val(e.latLng.lng);
  });

  marker = new window.google.maps.Marker({
    position: udc,
    map: map
  })
};

//Crea dinámicamente un checkbox para las secciones de los catálogos
function createCheck(nombre, val, classType, checked = false, isRadio = false, isTipo = true){
  var type = "checkbox";
  var name = nombre;
  if(isRadio) {
    type = "radio";
    name = isTipo ? "tipo" : 'delegacion';
  }

  var tempCheck = $(`<input type="${type}" ${checked ? 'checked' : ''} name="${name}" value="${val}" class="form-check-input ${classType}">`)
  var tempLabel = $(`<label for="${nombre}" class="form-check-label">&nbsp;${nombre}</label>`)
  var divTemp = $('<div class="form-check"></div>').append(tempCheck, tempLabel);

  return divTemp;
}

$('#inputImagen').change(function(event) {
  console.log('input image');
  let input = get('inputImagen');
  let reader = new FileReader()
  reader.onload = function (e) {
    document.getElementById('imageUbicacion').src = e.target.result;
  }
  reader.readAsDataURL(input.files[0])
});

//Agregar nuevo dirigido
$('#btnOtroDirig').on('click', () =>{
  var newDirig = get('txtOtroDirig');
  if(newDirig.value.trim()){
    var exist = dirigido.find(e => e.nombre.toLowerCase() == newDirig.value.trim().toLowerCase());
    if (!exist){
      $('#feedDirigido').attr('hidden', true);
      $('#formEquip').removeClass('has-danger');

      window.axios.post(gURL + 'api/dirigido', {nombre: newDirig.value})
      .then(({data}) => {
        newDirig.value = '';
        var divTemp = createCheck(data.nombre, data.id, "dirigido", true);
        dirigido.length % 2 == 0 ? $('#colDirigido1'). append(divTemp) : $('#colDirigido2').append(divTemp);
        dirigido.push(data);
      })
      .catch(err => console.log(err));
    }
    else{
      $('#feedDirigido').removeAttr('hidden').text('El dirigido que tratas de agregar ya existe');
      $('#formDirigido').addClass('has-danger');
    }
  }
  else{
    $('#feedDirigido').removeAttr('hidden').text('Ingresa un dirigido');
    $('#formDirigido').addClass('has-danger');
  }
  newDirig.focus();
})

//Agregar nuevo equipamiento
$('#btnOtroEquip').on('click', () => {
  var newEquip = get('txtOtroEquip');
  if(newEquip.value.trim()) {
    var exist = equipamiento.find(e => e.nombre.toLowerCase() == newEquip.value.trim().toLowerCase());
    if(!exist) {
      $('#feedbackEquip').attr('hidden', true);
      $('#formEquip').removeClass('has-danger');

      window.axios.post(gURL + 'api/equipamiento', {nombre: newEquip.value})
        .then(({data}) => {
          newEquip.value = '';
          var divTemp = createCheck(data.nombre, data.id, "equipamiento", true);
          equipamiento.length % 2 == 0 ? $('#colEquipamiento1').append(divTemp) : $('#colEquipamiento2').append(divTemp);
          equipamiento.push(data);
        })
        .catch(err => console.log(err))
    }
    else {
      $('#feedbackEquip').removeAttr('hidden').text('El equipamiento que tratas de agregar ya existe');
      $('#formEquip').addClass('has-danger');     
    }
  }
  else {
    $('#feedbackEquip').removeAttr('hidden').text('Ingresa un equipamiento');
    $('#formEquip').addClass('has-danger');
  }
  newEquip.focus();
})

//Agregar nueva actividad
$('#btnOtraActi').on('click', () => {
  var newActi = get('txtOtraActi');
  if(newActi.value.trim()) {
    var exist = actividades.find(e => e.nombre.toLowerCase() == newActi.value.trim().toLowerCase());
    if(!exist) {
      $('#feedbackActi').attr('hidden', true);
      $('#formActi').removeClass('has-danger');

      window.axios.post(gURL + 'api/actividad', {nombre: newActi.value})
        .then(({data}) => {
          newActi.value = '';
          var divTemp = createCheck(data.nombre, data.id, "actividad", true);
          actividades.length % 2 == 0 ? $('#colActividad1').append(divTemp) : $('#colActividad2').append(divTemp);
          actividades.push(data);
        })
        .catch(err => console.log(err))
    }
    else {
      $('#feedbackActi').removeAttr('hidden').text('La actividad que tratas de agregar ya existe');
      $('#formActi').addClass('has-danger');      
    }
  }
  else {
    $('#feedbackActi').removeAttr('hidden').text('Ingresa una actividad');
    $('#formActi').addClass('has-danger');
  }
  newActi.focus();
})

//Agregar nuevo tipo de ubicación
$('#btnOtroTipo').on('click', () => {
  var newTipo = get('txtOtroTipo');
  if(newTipo.value.trim()) {
    var exist = tipos.find(e => e.nombre.toLowerCase() == newTipo.value.trim().toLowerCase());
    if(!exist) {
      $('#feedbackTipo').attr('hidden', true);
      $('#formTipo').removeClass('has-danger');

      window.axios.post(gURL + 'api/tipoUbicacion', {nombre: newTipo.value})
        .then(({data}) => {
          newTipo.value = '';
          var divTemp = createCheck(data.nombre, data.id, "tipo", true, true);
          tipos.length % 2 == 0 ? $('#colTipo1').append(divTemp) : $('#colTipo2').append(divTemp);
          tipos.push(data);
        })
        .catch(err => console.log(err))
    }
    else {
      $('#feedbackTipo').removeAttr('hidden').text('El tipo de lugar que tratas de agregar ya existe');
      $('#formTipo').addClass('has-danger');      
    }
  }
  else {
    $('#feedbackTipo').removeAttr('hidden').text('Ingresa un tipo de lugar');
    $('#formTipo').addClass('has-danger');
  }
  newTipo.focus();
})

function getImageName(extension) {
  let date = new Date();
  return date.toISOString() + Math.random().toString().slice(2, 8) + '.' + extension;
}

$('#btnGuardar').on('click', () => {
  if(isCorrectInfo()) {
    console.log("Correcto");
    var btnGuardar = get('btnGuardar');
    btnGuardar.disabled = true;
    // btnGuardar.innerHTML = `<i class="fa fa-spinner" aria-hidden="true"></i>&nbsp;Cargando`;

    //Para sustituir las comas por espacios
    var clasificadores = $('#txtClasificadores').val();
    if(clasificadores != ''){
      var vec = clasificadores.split(',');
      clasificadores = "";
      for(var i = 0; i < vec.length; i++)
        clasificadores += vec[i] + " "; 
    }
    let imageName = getImageName(get('inputImagen').files[0].name.split('.').pop());

    var newUbicacion = {
      etiqueta: get('txtEtiqueta').value,
      cupo: get('txtCupo').value,
      titulo: get('txtTitulo').value,
      latitud: get('txtLatitud').value,
      longitud: get('txtLongitud').value,
      descripcion: editor.getData(),
      resumen: editorResumen.getData(),
      detalles: editorDetalles.getData(),
      idDelegacion: $("input[name='delegacion']:checked").val(),
      clasificadores: clasificadores.trim(),
      portada: imageName,
      idTipo: getSelectedCatalogosByClass('tipo', 5)[0].idEnCatalogo  //El 5 es sólo para rellenar
    };

    if (get('txtAgrupador').value != '')
      newUbicacion.agrupador = get('txtAgrupador').value;

    var modalErrorMessage = get('modalErrorMessage');
    window.axios.post(gURL + 'api/ubicacion?urlSitio=' + urlSitio, newUbicacion)
      .then(({data}) => {
        console.log("Ubicación guardada correctamente");
        console.log(data);

        var formData =  new FormData();
        formData.append("imagen", get('inputImagen').files[0]);       
        window.axios.post(gURL + 'api/ubicacion?imagen='+ imageName+'&idUbicacion=' + data.id, formData)
          .then((result) => {
            console.log("imagen guardada correctamente");
            console.log(result.data);
          })
          .catch(err => {
            modalErrorMessage.innerHTML += '<p>- Hubo un problema al guardar la imagen</p>';
            console.error(err)
          })

        window.axios.post(gURL + 'api/catalogos?table=equipamientoUbicacion', getSelectedCatalogosByClass('equipamiento', data.id))
          .then((result) => {
            console.log("Equipamientos guardados correctamente");
            console.log(result.data);
          })
          .catch(err => {
            modalErrorMessage.innerHTML += '<p>- Hubo un problema al guardar el equipamiento</p>';
            console.error(err)
          })

        window.axios.post(gURL + 'api/catalogos?table=actividadesUbicacion', getSelectedCatalogosByClass('actividad', data.id))
          .then((result) => {
            console.log("Actividades guardadas correctamente");
            console.log(result.data);
          })
          .catch(err => {
            modalErrorMessage.innerHTML += '<p>- Hubo un problema al guardar las actividades</p>';
            console.error(err)
          })

        window.axios.post(gURL + 'api/catalogos?table=dirigidoUbicacion', getSelectedCatalogosByClass('dirigido', data.id))
          .then((result) => {
            console.log("dirigido guardadas correctamente");
            console.log(result.data);
          })
          .catch(err => {
            modalErrorMessage.innerHTML += '<p>- Hubo un problema al guardar dirigido</p>';
            console.error(err)
          })

        $('#btnUbicacionAceptar').on('click', () => {
          window.location = gURL + '' + window.location.pathname.split('/')[2] + '/editar';
        });
        $('#ubicacionGuardada').modal();
      })
      .catch(err => {
        btnGuardar.disabled = false;
        $('#divErrors').addClass('has-danger');
        $('#feedbackErrors').html('<p>- Hubo un problema al guardar la ubicación, por favor inténtalo nuevamente</p>');
        $('#feedbackErrors').removeAttr('hidden');
        console.error(err)
      });   
  }
  else {
    console.log("Hay un error");
  }
});

$(window).load(() => {
  initMap();
  window.axios.get(gURL + 'api/equipamiento?activa=true')
    .then(({data}) => {
      equipamiento = data;
      for (var i = 0; i < data.length; i++) {
        var divTemp = createCheck(data[i].nombre, data[i].id, "equipamiento");
        i % 2 == 0 ? $('#colEquipamiento1').append(divTemp) : $('#colEquipamiento2').append(divTemp);
      }
    })
    .catch(err => console.log(err));

  window.axios.get(gURL + 'api/actividad?activa=true')
    .then(({data}) => {
      actividades = data;
      for (var i = 0; i < data.length; i++) {
        var divTemp = createCheck(data[i].nombre, data[i].id, "actividad");
        i % 2 == 0 ? $('#colActividad1').append(divTemp) : $('#colActividad2').append(divTemp);
      }
    })
    .catch(err => console.log(err));

  window.axios.get(gURL + 'api/dirigido?activa=true')
    .then(({data}) => {
      dirigido = data;
      for (var i = 0; i < data.length; i++) {
        var divTemp = createCheck(data[i].nombre, data[i].id, "dirigido");
        i % 2 == 0 ? $('#colDirigido1').append(divTemp) : $('#colDirigido2').append(divTemp);
      }
    })
    .catch(err => console.log(err));

  window.axios.get(gURL + 'api/tipoUbicacion?activo=true')
    .then(({data}) => {
      tipos = data;
      for (var i = 0; i < data.length; i++) {
        var divTemp = createCheck(data[i].nombre, data[i].id, "tipo", false, true);
        i % 2 == 0 ? $('#colTipo1').append(divTemp) : $('#colTipo2').append(divTemp);
      }
    })
    .catch(err => console.log(err));

  for (var i = 1; i <= 5; i++) {//Ver config.php para ver las delegaciones declaradas
    var divTemp = createCheck(delegaciones[i], i, "delegacion", i == defaultDelegacionId, true, false);
    (i - 1) % 2 == 0 ? $('#colDelegacion1').append(divTemp) : $('#colDelegacion2').append(divTemp);
  }

  editor = CKEDITOR.replace('txtDescripcion');
  editorResumen = CKEDITOR.replace('txtResumen', simpleCkeditorConfig);
  editorDetalles = CKEDITOR.replace('txtDetalles', simpleCkeditorConfig);
});

function testValues() {
  get('txtEtiqueta').value = "etiqueta de prueba"; 
  get('txtCupo').value = 32;
  get('txtTitulo').value = "Título de prueba";
  editor.setData("descripción de prueba");
}

function getSelectedCatalogosByClass(className, idUbica) {
  var result = [];
  $.each($(`.${className}`), function(index, val) {
    if(val.checked){
      var temp = { idUbicacion: idUbica, idEnCatalogo: val.value};
      result.push(temp);
    }
  }); 

  return result;
}

//************Validaciones
  function setFeedback(divName, feedbackName, feedbackMessage, thereIsError) {
    if(thereIsError) {
      $('#' + divName).addClass('has-danger');
      $('#' + feedbackName).text(feedbackMessage);
      $('#' + feedbackName).show();
      // window.location = href + '#' + divName;
    }
    else {
      $('#' + divName).removeClass('has-danger');
      $('#' + feedbackName).hide();
    }
  }

  function isEtiquetaValid(text) {
    var rg = new RegExp("^[a-zA-Z0-9\-]*$"); //Letras, números y guiones medios
    return text != '' && typeof text  === 'string' && rg.test(text) && text.length <= 50;
  }

  $('#txtEtiqueta').on('input', function() { //una especie de keypress
    var etiqueta = get('txtEtiqueta').value.trim();
    if(isEtiquetaValid(etiqueta)) {
      formatError = false;
      setFeedback('divEtiqueta', 'feedEtiqueta', '', false)
    }
    else {
      formatError = true;
      setFeedback('divEtiqueta', 'feedEtiqueta', ' Formato incorrecto', true)
    }
  });

  $('#txtEtiqueta').on('blur', () => {
    var text = get('txtEtiqueta').value;

    if(text != '') {
      window.axios.get(gURL + 'api/ubicacion?etiqueta=' + text)
        .then(({data}) => {
          if(!data.available)
            setFeedback('divEtiqueta', 'feedEtiqueta', ' Esta etiqueta ya no está disponible', true)
          else {
            if(!formatError)
              setFeedback('divEtiqueta', 'feedEtiqueta', '', false)
          }
        })
        .catch(err => {console.error(err);})
    }
    else {
      setFeedback('divEtiqueta', 'feedEtiqueta', ' No puede estar vacío', true)
    }
  });

  $('#txtTitulo').on('blur', function(){
    var text = get('txtTitulo').value.trim();
    var error = false;
    if(text == '')
      error = ' No puede estar vacío';
    else if(text.length > 70)
      error = ' Máximo 70 caracteres';

    error ? setFeedback('divTitulo', 'feedTitulo', error, true) : setFeedback('divTitulo', 'feedTitulo', '', false);
  });

  $('#txtCupo').on('blur', function() {
    var cupo = get('txtCupo').value; 
    var error = false;
    if(cupo == '')
      error = ' No puede estar vacío';
    else if(cupo < 1 || cupo > 3000)
      error = ' El cupo debe de estar entre 1 y 3000';

    error ? setFeedback('divCupo', 'feedCupo', error, true) : setFeedback('divCupo', 'feedCupo', '', false);
  });

  function isCorrectInfo() {
    var error = false;
    var equipValid = false;
    var actiValid = false;
    var dirigidoValid = false;
    var tipoValid = false;

    var etiqueta = get('txtEtiqueta').value.trim();
    if(etiqueta != '') {
      window.axios.get(gURL + 'api/ubicacion?etiqueta=' + etiqueta)
        .then(({data}) => {
          if(!data.available){
            setFeedback('divEtiqueta', 'feedEtiqueta', ' Esta etiqueta ya no está disponible', true)
            window.location.href = href + '#divEtiqueta';
            error = true;            
          }
          else {
            if(!formatError) {
              setFeedback('divEtiqueta', 'feedEtiqueta', '', false)
            }
            error = formatError;
          }
        })
        .catch(err => {console.log(err);})
    }
    else {
      setFeedback('divEtiqueta', 'feedEtiqueta', ' No puede estar vacío', true);
      window.location.href = href + '#divEtiqueta';
    }

    var titulo = get('txtTitulo').value.trim(); 
    if(titulo != '') {
      if(titulo.length > 70) {
        setFeedback('divTitulo', 'feedTitulo', ' Máximo 70 caracteres', true);
        if(!error) {
          error = true;
          window.location.href = href + '#divTitulo';
        }
      }
      else
        setFeedback('divTitulo', 'feedTitulo', '', false);
    }
    else {
      setFeedback('divTitulo', 'feedTitulo', ' No puede estar vacío', true);
      if(!error) {
        error = true;
        window.location.href = href + '#divTitulo';
      }
    }

    var cupo = get('txtCupo').value.trim(); 
    if(cupo != '') {
      if(cupo < 1 || cupo > 3000) {
        setFeedback('divCupo', 'feedCupo', ' El cupo debe de estar entre 1 y 3000', true);
        if(!error) {
          error = true;
          window.location.href = href + '#divCupo';
        }
      }
      else
        setFeedback('divCupo', 'feedCupo', '', false);
    }
    else {
      setFeedback('divCupo', 'feedCupo', ' No puede estar vacío', true);
      if(!error) {
        error = true;
        window.location.href = href + '#divCupo';
      }
    }

    var resumen = editorResumen.getData().trim();
    var ckResumen = get('cke_txtResumen');
    if(resumen != '') {
      if(resumen.length > 1000) {
        setFeedback('divResumen', 'feedResumen', ' Máximo 1000 caracteres', true);
        ckResumen.style.borderColor = '#d9534f';
        if(!error) {
          error = true;
          window.location.href = href + '#divResumen';
        }
      }
      else {
        setFeedback('divResumen', 'feedResumen', '', false);
        ckResumen.style.borderColor = '#ccc';
      }
    }
    else {
      setFeedback('divResumen', 'feedResumen', ' No puede estar vacío', true);
      ckResumen.style.borderColor = '#d9534f';
      if(!error) {
        error = true;
        window.location.href = href + '#divResumen';
      }
    }

    var descripcion = editor.getData().trim();
    var ckdescripcion = get('cke_txtDescripcion');
    if(descripcion == '') { //No tiene límite
      setFeedback('divDescripcion', 'feedDescripcion', ' No puede estar vacío', true);
      ckdescripcion.style.borderColor = '#d9534f';
      if(!error) {
        error = true;
        window.location.href = href + '#divDescripcion';
      }
    }
    else {
      setFeedback('divDescripcion', 'feedDescripcion', '', false);
      ckdescripcion.style.borderColor = '#ccc';
    }

    var detalles = editorDetalles.getData().trim();
    var ckdetalles = get('cke_txtDetalles');
    if(detalles != '') {
      if(detalles.length > 1000) {
        setFeedback('divDetalles', 'feedDetalles', ' Máximo 1000 caracteres', true);
        ckdetalles.style.borderColor = '#d9534f';
        if(!error) {
          error = true;
          window.location.href = href + '#divDetalles';
        }
      }
      else {
        setFeedback('divDetalles', 'feedDetalles', '', false);
        ckdetalles.style.borderColor = '#ccc';
      }
    }
    else {
      setFeedback('divDetalles', 'feedDetalles', ' No puede estar vacío', true);
      ckdetalles.style.borderColor = '#d9534f';
      if(!error) {
        error = true;
        window.location.href = href + '#divDetalles';
      }
    }

    var files = get('inputImagen').files; 
    if(files.length == 0) {
      setFeedback('divImagen', 'feedImagen', ' La imagen de portada es requerida', true);
      $('#divImagen2').addClass('has-danger');
      if(!error) {
        error = true;
        window.location.href = href + '#divImagen2';
      }
    }
    else {
      setFeedback('divImagen', 'feedImagen', '', false);
      $('#divImagen2').removeClass('has-danger');
    }

    var clasificadores = $('#txtClasificadores').val();
    if(clasificadores.length > 500) {
      $('#clasificadoresLimit').removeClass('text-muted');
      $('#clasificadoresLimit').addClass('text-danger');
      if(!error) {
        error = true;
        window.location.href = href + '#divImagen';
      }
    }
    else {
      $('#clasificadoresLimit').removeClass('text-danger');
      $('#clasificadoresLimit').addClass('text-muted');
    }

    $.each($('.equipamiento'), function(index, val) {
      if(val.checked){
        equipValid = true;
        return;
      }
    });
    var fieldsetEquip = get('fieldsetEquip');
    if(!equipValid) {
      setFeedback('divEquipamiento', 'feedEquipamiento', ' Debes seleccionar por lo menos una opción', true);
      fieldsetEquip.style.borderColor = '#d9534f';
      if(!error) {
        error = true;
        window.location.href = href + '#divEquipamiento';
      }
    }
    else {
      setFeedback('divEquipamiento', 'feedEquipamiento', '', false);
      fieldsetEquip.style.borderColor = 'rgba(0,0,0,.25)';
    }

    $.each($('.actividad'), function(index, val) {
      if(val.checked){
        actiValid = true;
        return;
      }
    });
    var fieldsetAct = get('fieldsetAct');
    if(!actiValid) {
      setFeedback('divActividades', 'feedActividades', ' Debes seleccionar por lo menos una opción', true);
      fieldsetAct.style.borderColor = '#d9534f';
      if(!error) {
        error = true;
        window.location.href = href + '#divActividades';
      }
    }
    else {
      setFeedback('divActividades', 'feedActividades', '', false);
      fieldsetAct.style.borderColor = 'rgba(0,0,0,.25)';
    }

    $.each($('.dirigido'), function(index, val) {
      if(val.checked){
        dirigidoValid = true;
        return;
      }
    });
    var fieldsetAct = get('fieldsetDirigido');
    if(!dirigidoValid) {
      setFeedback('divDirigido', 'feedDirigido', ' Debes seleccionar por lo menos una opción', true);
      fieldsetAct.style.borderColor = '#d9534f';
      if(!error) {
        error = true;
        window.location.href = href + '#divDirigido';
      }
    }
    else {
      setFeedback('divDirigido', 'feedDirigido', '', false);
      fieldsetAct.style.borderColor = 'rgba(0,0,0,.25)';
    }

    $.each($('.tipo'), function(index, val) {
      if(val.checked){
        tipoValid = true;
        return;
      }
    });   
    var fieldsetTipo = get('fieldsetTipo');
    if(!tipoValid) {
      setFeedback('divTipo', 'feedTipo', ' Debes seleccionar por lo menos una opción', true);
      fieldsetTipo.style.borderColor = '#d9534f';
      if(!error) {
        error = true;
        window.location.href = href + '#divTipo';
      }
    }
    else {
      setFeedback('divTipo', 'feedTipo', '', false);
      fieldsetTipo.style.borderColor = 'rgba(0,0,0,.25)';
    }

    history.replaceState(null, 'Hola mundo', gURL + '' + urlSitio + '/crear-ubicacion');
    return !error;
  }
//************Validaciones FIN