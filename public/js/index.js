var ubicaciones = [];
var allTags = [ ];
var searched = [ ];

function get(id) {return document.getElementById(id);}

var divCards = get('divCards');

var idDelegacion = false;

function createClasificadores(arr) {
  var clasificadores = "";
  for(var i = 0, length = arr.length; i < length; i++)
    clasificadores += '<span class="label label-primary">' + arr[i] + '</span>&nbsp;';
  return clasificadores;
}

function filterUbicaciones(idDelegacion = false) {
  if (searched.length > 0 || idDelegacion) {

    var s = '%' + searched.join("%' AND clasificadores LIKE '%") + '%';
    var searchURL = url+'api/ubicacion?tags=tags';
    if(idDelegacion)
      searchURL += '&delegacion=' + idDelegacion;

    window.axios.post(searchURL, { tags: s  })
    .then(function(res) {
      console.log(res.data)
      $('.card-ubicacion').hide();
      if (res.data.length > 0) {
        res.data.forEach(function(e) {
          $('#card-' + e.id).show();
        })
        $('#txtSearchResult').hide()
      } else {
        $('#txtSearchResult').show()
      }
    })
  } else {
    $('#txtSearchResult').hide()
    $('.card-ubicacion').show();
  }
}

$(document).ready(function () {
  var pTags = $('#tags');
  var exp = '^$';
  var rg = new RegExp(exp);
  var tags = $('.static-tag');
  for (var i = 0, j = tags.length; i < j; i++) {
    var tag = $(tags[i]).text();
    if (!rg.test(tag)) {
      allTags.push(tag);
      pTags.append('<button class="label label-default tag" value="0">' + tag + '</button>&nbsp');
      exp += '|' + tag;
      rg = new RegExp(exp);
    }
  }

  $('.tag').on('click', function() {
    if (this.value == 0){
      this.classList.value = 'label label-primary tag';
      searched.push(this.textContent);
      this.value = 1;
    } else {
      searched.splice(searched.indexOf(this.textContent), 1)
      this.classList.value = 'label label-default tag';
      this.value = 0;
    }
    filterUbicaciones(idDelegacion);
  });
});

$('.delegacion').on('click', function () {
  if (idDelegacion == false || this.value != idDelegacion) {//No seleccionó ninguna delegación o se seleccionó una diferente
    $('.delegacion').attr('class', 'label label-default delegacion');
    $(this).attr('class', 'label label-primary delegacion');
    filterUbicaciones(this.value);
    idDelegacion = this.value;
  } else {
    $(this).attr('class', 'label label-default delegacion');
    filterUbicaciones();
    idDelegacion = false;
  }
})

// $('#selectDelegaciones').on('change', function() {
//   var idDelegacion = $(this).val();
//   if(idDelegacion == -2) {
//     $('.card-ubicacion').show();
//     $('#txtSearchResult').hide();
//   }
//   else
//     filterUbicaciones(idDelegacion);

// });