var url = '/calendarios/buscar/';
axios.get(url).then(function(response) {
	console.log(response);
	$('#calendar').fullCalendar({
		eventLimit: true,
		  views: {
		    agenda: {
		      eventLimit: 6
		    }
		  },
		lang: 'es',
		aspectRatio: 1.7,
	  	header: {
		    left: 'prev,next today ',
		    center: 'title',
		    right: 'month,agendaWeek,agendaDay'
		},
		events: response.data,
		eventRender: function(eventObj, $el) {
		    $el.popover({
		    	title: eventObj.title,
		        content: eventObj.description,
		        trigger: 'hover',
		        placement: 'top',
		        container: 'body'
		    });
		},
		eventClick: function(calEvent, jsEvent, view) {
			var url = '/calendarios/buscarevento/' + calEvent.id;
			axios.get(url).then(function(response) {
				console.log(response.data);
				if (response.data[0].created_by == 1) {
					$('#update-event-form input[name=calendar_id]').val(calEvent.id);
	                $('#update-event-form input[name=title]').val(response.data[0].title);
	                for(j=0;j<(response.data[0].share_users).length;j++){
	                	console.log((response.data[0]).share_users[j].user_id);
						$('#share_users_update option[value='+(response.data[0]).share_users[j].user_id+']').prop('selected', 'selected').change();
	                }
					for(j=0;j<(response.data[0].share_departments).length;j++){
	                	console.log((response.data[0]).share_departments[j].role_id);
						$('#share_departments_update option[value='+(response.data[0]).share_departments[j].role_id+']').prop('selected', 'selected').change();
	                }
	                $('#update-event-form input[name=startdate]').val(response.data[0].startdate);
	                $('#update-event-form input[name=enddate]').val(response.data[0].enddate);
	                $('#update-event-form input[name=start_time]').val(response.data[0].start_time);
	                $('#update-event-form input[name=end_time]').val(response.data[0].end_time);
	                $('#update-event-form select[name=color]').val(response.data[0].color).change();
	                $('#update-event-form textarea[name=message]').val(response.data[0].message);
	                $('#update-event-modal').modal('show');
				}else{
					$('#info-event-form input[name=calendar_id]').val(calEvent.id);
	                $('#info-event-form input[name=title]').val(response.data[0].title);
					for(j=0;j<(response.data[0].share_users).length;j++){
	                	console.log((response.data[0]).share_users[j].user_id);
						$('#share_users_info option[value='+(response.data[0]).share_users[j].user_id+']').prop('selected', 'selected').change();
	                }
					for(j=0;j<(response.data[0].share_departments).length;j++){
	                	console.log((response.data[0]).share_departments[j].role_id);
						$('#share_departments_info option[value='+(response.data[0]).share_departments[j].role_id+']').prop('selected', 'selected').change();
	                }
					$('#info-event-form select[name=share_users]').val(response.data[0].share_users).change();
	                $('#info-event-form input[name=startdate]').val(response.data[0].startdate);
	                $('#info-event-form input[name=enddate]').val(response.data[0].enddate);
	                $('#info-event-form input[name=start_time]').val(response.data[0].start_time);
	                $('#info-event-form input[name=end_time]').val(response.data[0].end_time);
	                $('#info-event-form textarea[name=message]').val(response.data[0].message);
	                $('#info-event-modal').modal('show');
				}
		    }).catch(function(error) {
				console.log(response.error);
		        $.NotificationApp.send("Error!", "Ocurrió un problema al buscar la información del evento.", 'top-right', 'rgba(0,0,0,0.2)', 'error');
		    })
		}
	})
}).catch(function(error) {
    console.log(response.error);
	$.NotificationApp.send("Error!", "Ocurrió un problema al cargar el calendario.", 'top-right', 'rgba(0,0,0,0.2)', 'error');
})