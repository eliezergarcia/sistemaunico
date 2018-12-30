// ! function(e) {
//     "use strict";
//     var t = function() {
//         this.$body = e("body"), this.$modal = e("#event-modal"), this.$event = "#external-events div.external-event", this.$calendar = e("#calendar"), this.$saveCategoryBtn = e(".save-category"), this.$categoryForm = e("#add-category form"), this.$extEvents = e("#external-events"), this.$calendarObj = null
//     };
//     t.prototype.onDrop = function(t, n) {
//         var a = t.data("eventObject"),
//             l = t.attr("data-class"),
//             i = e.extend({}, a);
//         i.start = n, l && (i.className = [l]), this.$calendar.fullCalendar("renderEvent", i, !0), e("#drop-remove").is(":checked") && t.remove()
//     }, t.prototype.onEventClick = function(t, n, a) {
//         var l = this,
//             i = e("<form></form>");
//         i.append("<label>Change event name</label>"), i.append("<div class='input-group m-b-15'><input class='form-control' type=text value='" + t.title + "' /><span class='input-group-append'><button type='submit' class='btn btn-success btn-md  '><i class='fa fa-check'></i> Save</button></span></div>"), l.$modal.modal({
//             backdrop: "static"
//         }), l.$modal.find(".delete-event").show().end().find(".save-event").hide().end().find(".modal-body").empty().prepend(i).end().find(".delete-event").unbind("click").click(function() {
//             l.$calendarObj.fullCalendar("removeEvents", function(e) {
//                 return e._id == t._id
//             }), l.$modal.modal("hide")
//         }), l.$modal.find("form").on("submit", function() {
//             return t.title = i.find("input[type=text]").val(), l.$calendarObj.fullCalendar("updateEvent", t), l.$modal.modal("hide"), !1
//         })
//     }, t.prototype.onSelect = function(t, n, a) {
//         var l = this;
//         l.$modal.modal({
//             backdrop: "static"
//         });
//         var i = e("<form></form>");
//         i.append("<div class='row'></div>"), i.find(".row").append("<div class='col-12'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>").append("<div class='col-12'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>").find("select[name='category']").append("<option value='bg-danger'>Danger</option>").append("<option value='bg-success'>Success</option>").append("<option value='bg-primary'>Primary</option>").append("<option value='bg-info'>Info</option>").append("<option value='bg-dark'>Dark</option>").append("<option value='bg-warning'>Warning</option></div></div>"), l.$modal.find(".delete-event").hide().end().find(".save-event").show().end().find(".modal-body").empty().prepend(i).end().find(".save-event").unbind("click").click(function() {
//             i.submit()
//         }), l.$modal.find("form").on("submit", function() {
//             var e = i.find("input[name='title']").val(),
//                 a = (i.find("input[name='beginning']").val(), i.find("input[name='ending']").val(), i.find("select[name='category'] option:checked").val());
//             return null !== e && 0 != e.length ? (l.$calendarObj.fullCalendar("renderEvent", {
//                 title: e,
//                 start: t,
//                 end: n,
//                 allDay: !1,
//                 className: a
//             }, !0), l.$modal.modal("hide")) : alert("You have to give a title to your event"), !1
//         }), l.$calendarObj.fullCalendar("unselect")
//     }, t.prototype.enableDrag = function() {
//         e(this.$event).each(function() {
//             var t = {
//                 title: e.trim(e(this).text())
//             };
//             e(this).data("eventObject", t), e(this).draggable({
//                 zIndex: 999,
//                 revert: !0,
//                 revertDuration: 0
//             })
//         })
//     }, t.prototype.init = function() {
//         this.enableDrag();
//         var t = new Date,
//             n = (t.getDate(), t.getMonth(), t.getFullYear(), new Date(e.now())),
//             a = [{
//                 title: "Hey!",
//                 start: new Date(e.now() + 158e6),
//                 className: "bg-warning"
//             }, {
//                 title: "See John Deo",
//                 start: n,
//                 end: n,
//                 className: "bg-success"
//             }, {
//                 title: "Meet John Deo",
//                 start: new Date(e.now() + 168e6),
//                 className: "bg-info"
//             }, {
//                 title: "Buy a Theme",
//                 start: new Date(e.now() + 338e6),
//                 className: "bg-primary"
//             }],
//             l = this;
//         l.$calendarObj = l.$calendar.fullCalendar({
//             slotDuration: "00:15:00",
//             minTime: "08:00:00",
//             maxTime: "19:00:00",
//             defaultView: "month",
//             handleWindowResize: !0,
//             height: e(window).height() - 200,
//             header: {
//                 left: "prev,next today",
//                 center: "title",
//                 right: "month,agendaWeek,agendaDay"
//             },
//             events: a,
//             editable: !0,
//             droppable: !0,
//             eventLimit: !0,
//             selectable: !0,
//             drop: function(t) {
//                 l.onDrop(e(this), t)
//             },
//             select: function(e, t, n) {
//                 l.onSelect(e, t, n)
//             },
//             eventClick: function(e, t, n) {
//                 l.onEventClick(e, t, n)
//             }
//         }), this.$saveCategoryBtn.on("click", function() {
//             var e = l.$categoryForm.find("input[name='category-name']").val(),
//                 t = l.$categoryForm.find("select[name='category-color']").val();
//             null !== e && 0 != e.length && (l.$extEvents.append('<div class="external-event bg-' + t + '" data-class="bg-' + t + '" style="position: relative;"><i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>' + e + "</div>"), l.enableDrag())
//         })
//     }, e.CalendarApp = new t, e.CalendarApp.Constructor = t
// }(window.jQuery),
// function(e) {
//     "use strict";
//     e.CalendarApp.init()
// }(window.jQuery);

// $(function() {

//   // page is now ready, initialize the calendar...
	var url = '/calendarios/buscar/';
	axios.get(url).then(function(response) {
		console.log(response);
		$('#calendar').fullCalendar({
			lang: 'es',
			aspectRatio: 1.7,
		  	header: {
			    left: 'prev,next today ',
			    center: 'title',
			    right: 'month,agendaWeek,agendaDay'
			},
			events: response.data,
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

// });