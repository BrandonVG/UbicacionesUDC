function httpRequestCalendario(method, url, params, callback) {
  var req = new XMLHttpRequest();
  method = method.toUpperCase();

  req.open(method, url, true);
  req.setRequestHeader("Content-type", "application/json");

  req.onerror = function() {
    callback(true, req.responseText);
  }
  req.onload = function() {
    if(req.readyState == 4 && req.status == 200) 
      callback(false, JSON.parse(req.responseText));
    else
      callback(true, req.responseText);
  }

  req.send(JSON.stringify(params));
}

// calendario
var days = [];

function Calendar (url) {
  var popoverElement;
	var popTemplate = `<div class="popover fc-unthemed">
		<div class="fc-popover fc-more-popover">
			<div class="fc-header fc-widget-header">
			<span class="popover-title fc-title"></span>
			<button id="closepopover" type="button" class="close" aria-hidden="true" style="float: right">&times;</button>
			</div>
			<div class="fc-body fc-widget-content">
				<div class="popover-content"></div>
			</div>
		</div>
  </div>`


  $('body').on('click', function (e) {
    // close the popover if: click outside of the popover || click on the close button of the popover
    if (popoverElement && ((!popoverElement.is(e.target) && popoverElement.has(e.target).length === 0 && $('.popover').has
  (e.target).length === 0) || (popoverElement.has(e.target) && e.target.id === 'closepopover'))) {
      $('.popover').popover('hide');
    }
  });

  httpRequestCalendario('get', url, null, function (err, res) {
    if (err) {
      console.error(res);
      $('#calendar').fullCalendar({});
    } else {
      for (let index = 0; index < res.length; index++) {
        days.push({
          title: res[index].nombre + ' ' + res[index].horaInicio.substring(0,5) + ' - ' + res[index].horaFin.substring(0,5),
          start: res[index].fecha + 'T' + res[index].horaInicio,
          end: res[index].fecha + 'T' + res[index].horaFin,
          aceptado: res[index].aceptado,
          color: res[index].aceptado == 1 ? '#00a65a' : '#f39c12',
          textColor: '#fff !important'
        })
      }
      var popConfig = function (date, event) { 
        return{
          title:  date !== undefined ? date.getDate() + ' de agosto de 2018' : '',
          content: function () {
            return '<div class="fc-body fc-widget-content">' +
                '<div class="fc-event-container">' +
                  '<a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end" style="background-color:' + event.color + '; border-color:' + event.color + '; color:#fff !important" data-original-title="" title="">' +
                    '<div class="fc-content">' +
                      '<span class="fc-title">' + event.title + '</span>' +
                    '</div>'+
                  '</a>' +
                '</div>' +
              '</div>'
          },
          template: popTemplate,
          placement: 'left',
          html: 'true',
          trigger: 'click',
          animation: 'true',
          container: 'body'
        }
      }

      $('#calendar').fullCalendar({
        events: days,
        eventLimit: 1, // for all non-agenda views
        eventLimitText: 'mÃ¡s',
        select: function (start, end, jsEvent) {
          popoverElement = $(jsEvent.target);
          $(jsEvent.target).popover(popConfig()).popover('show');
        },
        eventClick: function (calEvent, jsEvent, view) {
          popoverElement = $(jsEvent.currentTarget);
          $('.popover').not('#' + $(jsEvent.currentTarget).attr('aria-describedby')).popover('hide');
        },

        eventRender: function (event, element) {
          var day = event.start._i.substring(0,10).split('-');
          var pop = element.popover(popConfig(new Date(day[0], day[1] - 1, day[2]), event));
        },
      });
    }
  });
  
}