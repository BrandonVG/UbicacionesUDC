$(window).load(function() {
  window.axios.get('/ubicaciones/api/catalogos?table=equipamientoUbicacion'+
    '&idUbicacion=' + idUbicacion)
    .then(({data}) => {
      equipamiento = data;
      for (var i = 0; i < data.length; i++) {
        let divTemp = $('<li></li>')
          .append(`${data[i].nombre}`);
        i % 2 == 0 ? $('#colEquipamiento1').append(divTemp) : $('#colEquipamiento2').append(divTemp);
      }
    })
    .catch(err => console.log(err));

  window.axios.get('/ubicaciones/api/catalogos?table=actividadesUbicacion'+
    '&idUbicacion=' + idUbicacion)
    .then(({data}) => {
      actividades = data;
      for (var i = 0; i < data.length; i++) {
        let divTemp = $('<li></li>')
          .append(`${data[i].nombre}`);
        i % 2 == 0 ? $('#colActividad1').append(divTemp) : $('#colActividad2').append(divTemp);
      }
    })
    .catch(err => console.log(err));

    window.axios.get('/ubicaciones/api/catalogos?table=dirigidoUbicacion'+
    '&idUbicacion=' + idUbicacion)
    .then(({data}) => {
      actividades = data;
      for (var i = 0; i < data.length; i++) {
        let divTemp = $('<li></li>')
          .append(`${data[i].nombre}`);
        i % 2 == 0 ? $('#colDirigido1').append(divTemp) : $('#colDirigido2').append(divTemp);
      }
    })
    .catch(err => console.log(err));
});
