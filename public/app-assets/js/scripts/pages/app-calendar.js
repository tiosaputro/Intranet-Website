/**
 * App Calendar
 */

/**
 * ! If both start and end dates are same Full calendar will nullify the end date value.
 * ! Full calendar will end the event on a day before at 12:00:00AM thus, event won't extend to the end date.
 * ! We are getting events from a separate file named app-calendar-events.js. You can add or remove events from there.
 **/

'use-strict';

// RTL Support
var direction = 'ltr',
  assetPath = '../../../app-assets/';
if ($('html').data('textdirection') == 'rtl') {
  direction = 'rtl';
}

if ($('body').attr('data-framework') === 'laravel') {
  assetPath = $('body').attr('data-asset-path');
}

$(document).on('click', '.fc-sidebarToggle-button', function (e) {
  $('.app-calendar-sidebar, .body-content-overlay').addClass('show');
});

$(document).on('click', '.body-content-overlay', function (e) {
  $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
});
$('#image').change(function(){

    let reader = new FileReader();
    reader.onload = (e) => {
    $('#preview-image').attr('src', e.target.result);
    $('#preview-image').attr('data-link', e.target.result);
    $('#preview-image').attr('class', 'lightboxed rounded');
    }
    reader.readAsDataURL(this.files[0]);

});

document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar'),
    eventToUpdate,
    sidebar = $('.event-sidebar'),
    calendarsColor = JSON.parse(colorCalendar),
    eventForm = $('.event-form'),
    addEventBtn = $('.add-event-btn'),
    cancelBtn = $('.btn-cancel'),
    updateEventBtn = $('.update-event-btn'),
    toggleSidebarBtn = $('.btn-toggle-sidebar'),
    eventTitle = $('#title'),
    eventLabel = $('#select-label'),
    startDate = $('#start-date'),
    endDate = $('#end-date'),
    eventUrl = $('#event-url'),
    eventGuests = $('#event-guests'),
    eventLocation = $('#event-location'),
    allDaySwitch = $('.allDay-switch'),
    repeatSwitch = $('.repeat'),
    selectAll = $('.select-all'),
    calEventFilter = $('.calendar-events-filter'),
    filterInput = $('.input-filter'),
    btnDeleteEvent = $('.btn-delete-event'),
    calendarEditor = $('#event-description-editor'),
    banner = $("#image");
    viewBanner = $(".showimage"),
    eventCategory = $(".select2")

  // --------------------------------------------
  // On add new item, clear sidebar-right field fields
  // --------------------------------------------
  $('.add-event button').on('click', function (e) {
    $('.event-sidebar').addClass('show');
    $('.sidebar-left').removeClass('show');
    $('.app-calendar .body-content-overlay').addClass('show');
  });

  // Label  select
  if (eventLabel.length) {
    function renderBullets(option) {
      if (!option.id) {
        return option.text;
      }
      var $bullet =
        "<span class='bullet bullet-" +
        $(option.element).data('label') +
        " bullet-sm me-50'> " +
        '</span>' +
        option.text;

      return $bullet;
    }
    eventLabel.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select value',
      dropdownParent: eventLabel.parent(),
      templateResult: renderBullets,
      templateSelection: renderBullets,
      minimumResultsForSearch: -1,
      escapeMarkup: function (es) {
        return es;
      }
    });
  }

  // Guests select
  if (eventGuests.length) {
    function renderGuestAvatar(option) {
      if (!option.id) {
        return option.text;
      }

      var $avatar =
        "<div class='d-flex flex-wrap align-items-center'>" +
        "<div class='avatar avatar-sm my-0 me-50'>" +
        "<span class='avatar-content'>" +
        "<img src='" +
        $(option.element).data('avatar') +
        "' alt='avatar' />" +
        '</span>' +
        '</div>' +
        option.text +
        '</div>';

      return $avatar;
    }
    eventGuests.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select value',
      dropdownParent: eventGuests.parent(),
      closeOnSelect: false,
      templateResult: renderGuestAvatar,
      templateSelection: renderGuestAvatar,
      escapeMarkup: function (es) {
        return es;
      }
    });
  }

  // Start date picker
  if (startDate.length) {
    var start = startDate.flatpickr({
      enableTime: true,
      altFormat: 'Y-m-dTH:i:S',
      onReady: function (selectedDates, dateStr, instance) {
        if (instance.isMobile) {
          $(instance.mobileInput).attr('step', null);
        }
      }
    });
  }

  // End date picker
  if (endDate.length) {
    var end = endDate.flatpickr({
      enableTime: true,
      altFormat: 'Y-m-dTH:i:S',
      onReady: function (selectedDates, dateStr, instance) {
        if (instance.isMobile) {
          $(instance.mobileInput).attr('step', null);
        }
      }
    });
  }

  // Event click function
  function eventClick(info) {
    eventToUpdate = info.event;
    $("#title").val(eventToUpdate.title);
    $("#event-url").val(eventToUpdate.url);
    if (eventToUpdate.url) {
      info.jsEvent.preventDefault();
      window.open(eventToUpdate.url, '_blank');
    }
    sidebar.modal('show');
    addEventBtn.addClass('d-none');
    cancelBtn.addClass('d-none');
    updateEventBtn.removeClass('d-none');
    btnDeleteEvent.removeClass('d-none');

    start.setDate(eventToUpdate.start, true, 'Y-m-d');
    eventToUpdate.allDay === true ? allDaySwitch.prop('checked', true) : allDaySwitch.prop('checked', false);
    eventToUpdate.extendedProps.repeat === true ? repeatSwitch.prop('checked', true) : repeatSwitch.prop('checked', false);
    eventToUpdate.end !== null
      ? end.setDate(eventToUpdate.end, true, 'Y-m-d')
      : end.setDate(eventToUpdate.start, true, 'Y-m-d');
    sidebar.find(eventLabel).val(eventToUpdate.extendedProps.calendar).trigger('change');

    eventToUpdate.extendedProps.location !== undefined ? eventLocation.val(eventToUpdate.extendedProps.location) : null;
    eventToUpdate.extendedProps.guests !== undefined
      ? eventGuests.val(eventToUpdate.extendedProps.guests).trigger('change')
      : null;
    eventToUpdate.extendedProps.guests !== undefined
      ? calendarEditor.val(eventToUpdate.extendedProps.description)
      : null;

    if ( eventToUpdate.extendedProps.banner !== "" ){
        var htmlImage = '<a href="'+eventToUpdate.extendedProps.banner+'" target="_blank"><img id="preview-image" class="lightboxed rounded" rel="group1" src="'+eventToUpdate.extendedProps.banner+'" width="120" height="120" style="max-height: 250px;" /></a>';
        $(".showimage").show()
        $("#showbanner").html(htmlImage);
    }else{
        $(".image").show()
        $(".showimage").hide()
        //add css style display none
        $("#showbanner").html("");
    }
    if(eventToUpdate.title !== ''){
        //show detail button
        $("#showDetailCalendar").html("<a href='/calendar/detail/"+eventToUpdate.id+"' class='btn btn-success me-1 waves-effect'>Detail Calendar</a>")
    }else{
        $("#showDetailCalendar").html('');
    }
    //  Delete Event
    btnDeleteEvent.on('click', function () {
      eventToUpdate.remove();
      // removeEvent(eventToUpdate.id);
      sidebar.modal('hide');
      $('.event-sidebar').removeClass('show');
      $('.app-calendar .body-content-overlay').removeClass('show');
    });
  }

  // Modify sidebar toggler
  function modifyToggler() {
    $('.fc-sidebarToggle-button')
      .empty()
      .append(feather.icons['menu'].toSvg({ class: 'ficon' }));
  }

  // Selected Checkboxes
  function selectedCalendars() {
    var selected = [];
    $('.calendar-events-filter input:checked').each(function () {
      selected.push($(this).attr('data-value'));
    });
    return selected;
  }

  // --------------------------------------------------------------------------------------------------
  // AXIOS: fetchEvents
  // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
  // --------------------------------------------------------------------------------------------------
  function fetchEvents(info, successCallback) {
    // Fetch Events from API endpoint reference
    // $.ajax(
    //   {
    //     url: '../../app-assets/data/app-calendar-events.js',
    //     type: 'GET',
    //     success: function (result) {
    //       // Get requested calendars as Array
    //       var calendars = selectedCalendars();

    //       return [result.events.filter(event => calendars.includes(event.extendedProps.calendar))];
    //     },
    //     error: function (error) {
    //       console.log(error);
    //     }
    //   }
    // );

    var calendars = selectedCalendars();
    // We are reading event object from app-calendar-events.js file directly by including that file above app-calendar file.
    // You should make an API call, look into above commented API call for reference
    selectedEvents = events.filter(function (event) {
      // console.log(event.extendedProps.calendar.toLowerCase());
      return calendars.includes(event.extendedProps.calendar.toLowerCase());
    });
    // if (selectedEvents.length > 0) {
    successCallback(selectedEvents);
    // }
  }
  // Calendar plugins
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: fetchEvents,
    editable: true,
    dragScroll: true,
    dayMaxEvents: 2,
    eventResizableFromStart: true,
    customButtons: {
      sidebarToggle: {
        text: 'Sidebar'
      }
    },
    headerToolbar: {
      start: 'sidebarToggle, prev,next, title',
      end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    direction: direction,
    initialDate: new Date(),
    navLinks: true, // can click day/week names to navigate views
    eventClassNames: function ({ event: calendarEvent }) {
      const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];

      return [
        // Background Color
        'bg-light-' + colorName
      ];
    },
    dateClick: function (info) {
      var date = moment(info.date).format('YYYY-MM-DD');
      resetValues();
      sidebar.modal('show');
      addEventBtn.removeClass('d-none');
      updateEventBtn.addClass('d-none');
      btnDeleteEvent.addClass('d-none');
      startDate.val(date);
      endDate.val(date);
    },
    eventClick: function (info) {
      eventClick(info);
    },
    datesSet: function () {
      modifyToggler();
    },
    viewDidMount: function () {
      modifyToggler();
    }
  });

  // Render calendar
  calendar.render();
  // Modify sidebar toggler
  modifyToggler();
  // updateEventClass();

  // Validate add new and update form
  if (eventForm.length) {
    eventForm.validate({
      submitHandler: function (form, event) {
        event.preventDefault();
        if (eventForm.valid()) {
          sidebar.modal('hide');
        }
      },
      title: {
        required: true
      },
      rules: {
        'start-date': { required: true },
        'end-date': { required: true }
      },
      messages: {
        'start-date': { required: 'Start Date is required' },
        'end-date': { required: 'End Date is required' }
      }
    });
  }

  // Sidebar Toggle Btn
  if (toggleSidebarBtn.length) {
    toggleSidebarBtn.on('click', function () {
      cancelBtn.removeClass('d-none');
    });
  }

  // ------------------------------------------------
  // addEvent
  // ------------------------------------------------
  function addEvent(eventData) {
    calendar.addEvent(eventData);
    calendar.refetchEvents();
  }

  // ------------------------------------------------
  // updateEvent
  // ------------------------------------------------
  function updateEvent(eventData) {
    var propsToUpdate = ['id', 'title', 'url', 'allDay','req_id','repeat'];
    var extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description','repeat'];

      updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
      calendar.refetchEvents();
  }

  // ------------------------------------------------
  // removeEvent
  // ------------------------------------------------
  function removeEvent(eventId) {
    removeEventInCalendar(eventId);
  }

  // ------------------------------------------------
  // (UI) updateEventInCalendar
  // ------------------------------------------------
  const updateEventInCalendar = (updatedEventData, propsToUpdate, extendedPropsToUpdate) => {
    const existingEvent = calendar.getEventById(updatedEventData.req_id);

    // --- Set event properties except date related ----- //
    // ? Docs: https://fullcalendar.io/docs/Event-setProp
    // dateRelatedProps => ['start', 'end', 'allDay']
    // eslint-disable-next-line no-plusplus
    for (var index = 0; index < propsToUpdate.length; index++) {
      var propName = propsToUpdate[index];
      existingEvent.setProp(propName, updatedEventData[propName]);
    }

    // --- Set date related props ----- //
    // ? Docs: https://fullcalendar.io/docs/Event-setDates
      existingEvent.setDates(updatedEventData.start, updatedEventData.end, { allDay: updatedEventData.allDay, repeat: updatedEventData.repeat });

    // --- Set event's extendedProps ----- //
    // ? Docs: https://fullcalendar.io/docs/Event-setExtendedProp
    // eslint-disable-next-line no-plusplus
    for (var index = 0; index < extendedPropsToUpdate.length; index++) {
      var propName = extendedPropsToUpdate[index];
      existingEvent.setExtendedProp(propName, updatedEventData.extendedProps[propName]);
    }
  };

  // ------------------------------------------------
  // (UI) removeEventInCalendar
  // ------------------------------------------------
  function removeEventInCalendar(eventId) {
    calendar.getEventById(eventId).remove();
  }

  // Add new event
  $(addEventBtn).on('click', function () {
    if (eventForm.valid()) {
        const fileUpload = $("#image").prop('files')[0];
        // you can't pass Jquery form it has to be javascript form object
        const formData = new FormData();
        formData.append('file', fileUpload);
        formData.append('id', calendar.getEvents().length+1);
        formData.append('title', eventTitle.val());
        formData.append('start', startDate.val());
        formData.append('end', endDate.val());
        formData.append('allDay', allDaySwitch.is(':checked'));
        formData.append('repeat', repeatSwitch.is(':checked'));
        formData.append('startStr', startDate.val());
        formData.append('endStr', endDate.val());
        formData.append('display', 'block');
        formData.append('display', 'block');
        const extend =  {
            location: eventLocation.val(),
            guests: eventGuests.val(),
            calendar: eventLabel.val(),
            description: calendarEditor.val()
          }
          //extend convert to array
        formData.append('extendedProps', JSON.stringify(extend))
      var newEvent = {
        id: calendar.getEvents().length + 1,
        title: eventTitle.val(),
        start: startDate.val(),
        end: endDate.val(),
        startStr: startDate.val(),
        endStr: endDate.val(),
        display: 'block',
        file : fileUpload,
        extendedProps: {
          location: eventLocation.val(),
          guests: eventGuests.val(),
          calendar: eventLabel.val(),
          description: calendarEditor.val()
        }
      };
      if (eventUrl.val().length) {
        newEvent.url = eventUrl.val();
        formData.append('url', eventUrl.val());
      }
      if (allDaySwitch.prop('checked')) {
        newEvent.allDay = true;
      }
      if (repeatSwitch.prop('checked')) {
        newEvent.repeat = true;
      }
    //send to database with ajax post
    $(".preloader").show();
    $.ajax({
        url: urlPost,
        type: 'POST',
        // dataType : 'json',
        enctype: 'multipart/form-data',
        data: formData,
        cache : false,
        processData : false,
        contentType : false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result) {
            $(".preloader").hide();
            //sweetalert success
            if (result.status == 'success') {
                Swal.fire({
                    title: "Success!",
                    text: "Event added successfully",
                    icon: "success",
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
                addEvent(newEvent);
            } else {
                //swal fire error
                Swal.fire({
                    title: "Error!",
                    text: "Event Failed! "+result.message,
                    icon : "error"
                })
            }
        },
        error: function (error) {
            //swal fire error
            Swal.fire({
                title: "Error!",
                text: "Event Failed! "+error,
                icon : "error"
            })
        }
    });

    } //endif valid
  });

  // Update new event
  updateEventBtn.on('click', function () {
    if (eventForm.valid()) {
        const fileUpload = $("#image").prop('files')[0];
        // you can't pass Jquery form it has to be javascript form object
        const formData = new FormData();
        formData.append('file', fileUpload);
        formData.append('id', eventToUpdate.id);
        formData.append('req_id', eventToUpdate.id);
        formData.append('title', eventTitle.val());
        formData.append('start', startDate.val());
        formData.append('end', endDate.val());
        formData.append('allDay', allDaySwitch.is(':checked'));
        formData.append('repeat', repeatSwitch.is(':checked'));
        formData.append('startStr', startDate.val());
        formData.append('endStr', endDate.val());
        formData.append('display', 'block');
        const extend =  {
            location: eventLocation.val(),
            guests: eventGuests.val(),
            calendar: eventLabel.val(),
            description: calendarEditor.val()
          }
        formData.append('extendedProps', JSON.stringify(extend))

        var eventData = {
        id: eventToUpdate.id,
        req_id: eventToUpdate.id,
        // req_id : eventToUpdate.req_id,
        title: sidebar.find(eventTitle).val(),
        start: sidebar.find(startDate).val(),
        end: sidebar.find(endDate).val(),
        url: eventUrl.val(),
        extendedProps: {
          location: eventLocation.val(),
          guests: eventGuests.val(),
          calendar: eventLabel.val(),
          description: calendarEditor.val()
        },
        display: 'block',
        allDay: allDaySwitch.prop('checked') ? true : false,
        repeat: repeatSwitch.prop('checked') ? true : false
      };

      if (eventUrl.val().length) {
        formData.append('url', eventUrl.val());
      }
      $(".preloader").show();
      $.ajax({
        url: urlPost,
        type: 'POST',
        // dataType : 'json',
        enctype: 'multipart/form-data',
        data: formData,
        cache : false,
        processData : false,
        contentType : false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //add file input
        success: function (result) {
            $(".preloader").hide();
            // console.log(result);
            //sweetalert success
            if (result.status == 'success') {
                updateEvent(eventData);
                Swal.fire({
                    title: "Success!",
                    text: result.message,
                    icon: "success",
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
                sidebar.modal('hide');
                //reload page
                location.reload();
            } else {
                //swal fire error
                Swal.fire({
                    title: "Error!",
                    text: "Event Failed! "+result.message,
                    icon : "error"
                })
            }
        },
        error: function (error) {
            //swal fire error
            Swal.fire({
                title: "Error!",
                text: "Event Failed! "+error,
                icon : "error"
            })
        }
      });

    } //event form valid
  });

  // Reset sidebar input values
  function resetValues() {
    endDate.val('');
    eventUrl.val('');
    startDate.val('');
    eventTitle.val('');
    eventLocation.val('');
    allDaySwitch.prop('checked', false);
    repeatSwitch.prop('checked', false);
    $("#repeat").prop('checked', false);
    eventGuests.val('').trigger('change');
    calendarEditor.val('');
    $("#showDetailCalendar").html('');
  }

  // When modal hides reset input values
  sidebar.on('hidden.bs.modal', function () {
    resetValues();
    $(".showimage").hide()
  });

  // Hide left sidebar if the right sidebar is open
  $('.btn-toggle-sidebar').on('click', function () {
    btnDeleteEvent.addClass('d-none');
    updateEventBtn.addClass('d-none');
    addEventBtn.removeClass('d-none');
    $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
  });

  // Select all & filter functionality
  if (selectAll.length) {
    selectAll.on('change', function () {
      var $this = $(this);

      if ($this.prop('checked')) {
        calEventFilter.find('input').prop('checked', true);
      } else {
        calEventFilter.find('input').prop('checked', false);
      }
      calendar.refetchEvents();
    });
  }

  if (filterInput.length) {
    filterInput.on('change', function () {
      $('.input-filter:checked').length < calEventFilter.find('input').length
        ? selectAll.prop('checked', false)
        : selectAll.prop('checked', true);
      calendar.refetchEvents();
    });
  }
});
