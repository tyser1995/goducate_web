@push('scripts')
<script>

    $('[data-mask]').inputmask();
    $('.book_now')[0].innerHTML = "Booking";
    
    $('.booking_option').change(function (e) { 
        e.preventDefault();
        // Hide all sections by default
        $('.overnight_stay, .day_tour, .place_reservation').addClass('d-none');

        var selectedOption = $(this).val();
        if (selectedOption === '0') {
            $('.overnight_stay').removeClass('d-none');

            $('#room_type').attr('required','required');
            $('#reservationtimeOS').attr('required','required');
            $('#checkin_date').attr('required','required');
            $('#checkout_date').attr('required','required');


            $('#reservationtimeDT').removeAttr('required');
            $('#dt_name').removeAttr('required');
            $('#tour_type').removeAttr('required');
            $('#group_type').removeAttr('required');
            $('#no_of_persons').removeAttr('required');
            $('#checkin_date_dt').removeAttr('required');
            $('#checkout_date_dt').removeAttr('required');

            $('#no_of_cottages').removeAttr('required');
            $('#reservationtimePR').removeAttr('required');
            $('#room_type_pr').removeAttr('required');
            $('#checkin_date').removeAttr('required');
            $('#checkout_date').removeAttr('required');
            
        } else if (selectedOption === '1') {
            $('.day_tour').removeClass('d-none');

            $('#reservationtimeDT').attr('required','required');
            $('#dt_name').attr('required','required');
            $('#tour_type').attr('required','required');
            $('#group_type').attr('required','required');
            $('#no_of_persons').attr('required','required');
            $('#checkin_date_dt').attr('required','required');
            $('#checkout_date_dt').attr('required','required');


            $('#room_type').removeAttr('required');
            $('#reservationtimeOS').removeAttr('required');
            $('#checkin_date').removeAttr('required');
            $('#checkout_date').removeAttr('required');

            $('#no_of_cottages').removeAttr('required');
            $('#reservationtimePR').removeAttr('required');
            $('#room_type_pr').removeAttr('required');
            $('#checkin_date').removeAttr('required');
            $('#checkout_date').removeAttr('required');
        } else if (selectedOption === '2') {
            $('.place_reservation').removeClass('d-none');

            $('#no_of_cottages').attr('required','required');
            $('#reservationtimePR').attr('required','required');
            $('#room_type_pr').attr('required','required');
            $('#checkin_date').attr('required','required');
            $('#checkout_date').attr('required','required');


            $('#room_type').removeAttr('required');
            $('#reservationtimeOS').removeAttr('required');
            $('#checkin_date').removeAttr('required');
            $('#checkout_date').removeAttr('required');

            $('#reservationtimeDT').removeAttr('required');
            $('#dt_name').removeAttr('required');
            $('#tour_type').removeAttr('required');
            $('#group_type').removeAttr('required');
            $('#no_of_persons').removeAttr('required');
            $('#checkin_date_dt').removeAttr('required');
            $('#checkout_date_dt').removeAttr('required');

        }
    });

    loadCalendar();

    // function formatRoomType(type) {
    //     return type
    //         .replace(/_/g, ' ')
    //         .split(' ')
    //         .map(word => word.charAt(0).toUpperCase() + word.slice(1))
    //         .join(' ');
    // }

    function loadCalendar() {
        var originalStartDate, originalEndDate;
        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var today = new Date().toISOString().split('T')[0];
          var existingBookings = [];

          // Initialize the calendar
          var calendar = new FullCalendar.Calendar(calendarEl, {
              selectable: true,
              initialView: 'dayGridMonth',
              validRange: {
                  start: today 
              },
              // Fetch existing bookings
              events: function(fetchInfo, successCallback, failureCallback) {
                  $.ajax({
                      url: "{{ route('bookings.list') }}",
                      type: 'GET',
                      dataType: 'json',
                      success: function(data) {
                          var events = [];
                          for (let i = 0; i < data.booking_list.length; i++) {
                              events.push({
                                title: data.booking_list[i].type,
                                start:    data.booking_list[i].combined_checkin_datetime,
                                end:  data.booking_list[i].combined_checkout_datetime,
                                allDay: true
                              });
                              // Store bookings for time disabling
                              // existingBookings.push({
                              //     start: data.data[i].checkin_date,
                              //     end: data.data[i].checkout_date
                              // });
                          }
                          successCallback(events);
                      },
                      error: function() {
                          failureCallback();
                      }
                  });
              },
              // Handle date click
              dateClick: function(info) {
                  if (info.dateStr >= today) {
                      $('#eventModalLabel')[0].innerHTML = "Booking date " + info.dateStr;

                      var selectedDate = moment(info.dateStr).startOf('day');  // Capture the full day

                      // Initialize the time picker
                      $('.reservationtime').daterangepicker({
                          timePicker: false,
                          // timePickerIncrement: 30,
                          startDate: selectedDate, 
                          endDate: selectedDate,
                          locale: {
                              format: 'MM/DD/YYYY'
                          },
                          autoApply: true,
                          drops: 'up',
                          isInvalidDate: function(date) {
                              // Disable past dates or Sundays
                              if (date.isBefore(selectedDate) || date.day() === 0) {
                                  return true;
                              }

                              // Disable times that overlap with existing bookings
                              // for (var i = 0; i < existingBookings.length; i++) {
                              //     var bookingStart = moment(existingBookings[i].start);
                              //     var bookingEnd = moment(existingBookings[i].end);
                              //     if (date.isBetween(bookingStart, bookingEnd, null, '[)')) {
                              //         return true;
                              //     }
                              // }
                              // return false;
                          }
                      }).on('show.daterangepicker', function(ev, picker) {
                          // When the date picker opens, store the currently selected start and end dates
                          originalStartDate = picker.startDate.clone();  // Clone to avoid reference issues
                          originalEndDate = picker.endDate.clone();
                      }).on('apply.daterangepicker', function(ev, picker) {
                          var startDate = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
                          var endDate = picker.endDate.format('YYYY-MM-DD HH:mm:ss');
                        
                          // var overlapFound = false; 
                          // for (var i = 0; i < existingBookings.length; i++) {
                          //     var bookingStart = moment(existingBookings[i].start);
                          //     var bookingEnd = moment(existingBookings[i].end);

                          //     if (picker.startDate.isBefore(bookingEnd) && picker.endDate.isAfter(bookingStart)) {
                          //         alert("Selected dates overlap with an existing booking. Please choose another date range.");
                                  
                          //         picker.setStartDate(originalStartDate);
                          //         picker.setEndDate(originalEndDate);

                          //         $('.btnSubmit').attr('disabled', 'disabled');  // Disable submit button
                          //         overlapFound = true; 
                          //     }
                          // }

                          $('.btnSubmit').removeAttr('disabled');
                              
                          // Set hidden input values
                          $('#checkin_date').val(startDate);
                          $('#checkout_date').val(endDate);
                          $('#checkin_date_dt').val(startDate);
                          $('#checkout_date_dt').val(endDate);
                          $('#checkin_date_pr').val(startDate);
                          $('#checkout_date_pr').val(endDate);
                      });

                      var formattedDate = moment(info.dateStr).format('YYYY-MM-DD HH:mm:ss');
                      $('#checkin_date').val(formattedDate);
                      $('#checkout_date').val(formattedDate);
                      $('#checkin_date_dt').val(formattedDate);
                      $('#checkout_date_dt').val(formattedDate);
                      $('#checkin_date_pr').val(formattedDate);
                      $('#checkout_date_pr').val(formattedDate);

                      $('#eventDate').val(info.dateStr);
                      $('#eventModal').modal('show');
                  } else {
                      alert('You cannot select a past date!');
                  }
              }
          });

          calendar.render();
      });

    }


    function showValidationModal(message) {
        $('#validationMessage').text(message);
        $('#validationModal').modal('show');
    }
    
    $('#quickForm').submit(function(event) {
      
        event.preventDefault();
        
        var selectedOption = $('.booking_option').val();

        if (selectedOption === '0') {
          const adults = parseInt($('#no_of_adults').val()) || 0;
          const children = parseInt($('#no_of_children').val()) || 0;
          const totalPersons = adults + children;

          let totalCapacity = 0;
          let validationFailed = false;

          $('.class_room_type').each(function() {
              const roomId = $(this).val();
              if (roomId) {
                  // Fetch room capacity via AJAX synchronously (could be async, but for simplicity, do it in sync)
                  $.ajax({
                      url: '/room-capacity/' + roomId,
                      type: 'GET',
                      async: false, // Ensures this runs in order; not recommended for large operations
                      success: function(response) {
                          if (response.capacity) {
                              totalCapacity += response.capacity;  // Add the room capacity to the total
                          }
                      },
                      error: function() {
                          alert('Could not fetch room capacity. Please try again.');
                          validationFailed = true;
                      }
                  });
              }
          });

          if (validationFailed) return;
          if (totalCapacity < totalPersons) {
              showValidationModal(`The total capacity of the selected rooms is ${totalCapacity}, but you have selected ${totalPersons} persons.`);

              return;
          }

          var $btn = $(this);

          $('.btnSubmit').attr('disabled', 'disabled');
          $btn.find('.fa-sync-alt').removeClass('d-none');

          var roomTypes = [];
          $('.class_room_type').each(function(){
              roomTypes.push($(this).val());
          });

          $.ajax({
              url: "{{ route('bookings.store') }}",
              type: "POST",
              data: {
                'name'            :$('#name').val(),
                'email'           :$('#email').val(),
                'address'         :$('#address').val(),
                'contact_no'      :$('#contact_no').val(),
                'no_of_adults'    :$('#no_of_adults').val(),
                'no_of_children'  :$('#no_of_children').val(),
                'boooking_status' :$('#boooking_status').val(),
                'checkin_date'    : $('#checkin_date').val(),
                'checkout_date'   : $('#checkout_date').val(),
                'accomodation_id' : roomTypes
              },
              success: function(response) {
                  
              },
              error: function(error) {
                  console.log(error)
              }
          });

          $.ajax({
              url: "{{ route('bookings.overnight_stay') }}",
              type: "POST",
              data: {
                'email'           : $('#email').val(),
                'room_type'      : roomTypes,
                'checkin_date'    : $('#checkin_date').val(),
                'checkout_date'   : $('#checkout_date').val()
              },
              success: function(response) {
                  $('#eventModal').modal('hide');
                  loadCalendar();
                  //location.reload();
                  $('#bookingMessage').modal('show');
              },
              error: function(error) {
                  console.log(error)
              }
          });
        } else if (selectedOption === '1') {
            $.ajax({
              url: "{{ route('bookings.store') }}",
              type: "POST",
              data: {
                'name'            :$('#name').val(),
                'email'           :$('#email').val(),
                'address'         :$('#address').val(),
                'contact_no'      :$('#contact_no').val(),
                'no_of_adults'    :$('#no_of_adults').val(),
                'no_of_children'  :$('#no_of_children').val(),
                'boooking_status' :$('#boooking_status').val(),
                'checkin_date'    : $('#checkin_date_dt').val(),
                'checkout_date'   : $('#checkout_date_dt').val()
              },
              success: function(response) {
                  
              },
              error: function(error) {
                  console.log(error)
              }
          });
          $.ajax({
              url: "{{ route('bookings.day_tour') }}",
              type: "POST",
              data: {
                'email'           :$('#email').val(),
                'name'            :$('#dt_name').val(),
                'tour_type'       :$('#tour_type').val(),
                'group_type'      :$('#group_type').val(),
                'no_of_persons'   :$('#no_of_persons').val(),
                'checkin_date'    :$('#checkin_date_dt').val(),
                'checkout_date'   :$('#checkout_date_dt').val()
              },
              success: function(response) {
                  $('#eventModal').modal('hide');
                  loadCalendar();
                  $('#bookingMessage').modal('show');
              },
              error: function(error) {
                  console.log(error)
              }
          });
        } else if (selectedOption === '2') {
          $('.place_reservation').removeClass('d-none');
            $.ajax({
              url: "{{ route('bookings.store') }}",
              type: "POST",
              data: {
                'name'            :$('#name').val(),
                'email'           :$('#email').val(),
                'address'         :$('#address').val(),
                'contact_no'      :$('#contact_no').val(),
                'no_of_adults'    :$('#no_of_adults').val(),
                'no_of_children'  :$('#no_of_children').val(),
                'boooking_status' :$('#boooking_status').val(),
                'checkin_date'    : $('#checkin_date_pr').val(),
                'checkout_date'   : $('#checkout_date_pr').val()
              },
              success: function(response) {
                  
              },
              error: function(error) {
                  console.log(error)
              }
          });

          $.ajax({
              url: "{{ route('bookings.place_reservation') }}",
              type: "POST",
              data: {
                'email'           :$('#email').val(),
                'room_type'       :$('#room_type_pr').val(),
                'no_of_cottages'  :$('#no_of_cottages').val(),
                'checkin_date'    :$('#checkin_date_pr').val(),
                'checkout_date'   :$('#checkout_date_pr').val()
              },
              success: function(response) {
                  $('#eventModal').modal('hide');
                  loadCalendar();
                  $('#bookingMessage').modal('show');
              },
              error: function(error) {
                  console.log(error)
              }
          });
        }
    });

    $('#tour_type').change(function (e) {
        e.preventDefault();
        var selectedOption = $(this).val();
        $('#dt_name').removeAttr('disabled');
        $('.dt_name_class').removeClass('d-none');
        if (selectedOption === 'team_building') {
          $('.gt').removeClass('d-none');
          $('#group_type').removeAttr('disabled');

          $('.no_person').addClass('d-none');
          $('#no_of_persons').attr('disabled','disabled');
        } else if (selectedOption === 'family') {
          $('.gt').addClass('d-none');
          $('#group_type').attr('disabled','disabled');

          $('.no_person').removeClass('d-none');
          $('#no_of_persons').removeAttr('disabled');
        }
    });

    $('#room_type_pr').change(function (e) { 
        e.preventDefault();
        var selectedOption = $(this).val();
        if (selectedOption === 'cottages' || selectedOption === 'small_huts') {
          $('.no_of_cottages').removeClass('d-none');
          $('#no_of_cottages').attr('required','required');
        } else {
          $('.no_of_cottages').addClass('d-none');
          $('#no_of_cottages').removeAttr('required');
        }
    });

    $('body').on('click', '.btn-add', function () {
        var roomTypeHtml = `
            <div class="input-group date mt-2">
                <select name="room_type" class="class_room_type form-control">
                    <option selected value="">Select option</option>
                    @foreach (App\Models\Accomodation::getAccomodationOvernightStay() as $value)
                        <option value="{{$value->id}}">{{$value->type}} &nbsp;&nbsp;&nbsp; (capacity: {{$value->capacity}})</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <button type="button" class="input-group-text btn btn-sm btn-danger btn-remove">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>`;

        // Append the new room dropdown to the container
        $('#room-container').append(roomTypeHtml);
    });

    // Function to remove a room dropdown
    $('body').on('click', '.btn-remove', function () {
        $(this).closest('.input-group').remove();  // Remove the closest room type input group
    });
    
    $('.btnClose').click(function (e) { 
      location.reload();
    });
  </script>
@endpush
