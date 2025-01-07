@push('scripts')
<script>

    $('[data-mask]').inputmask();
    $('.book_now')[0].innerHTML = "Booking";
    
    $('.booking_option').change(function (e) {
        e.preventDefault();
        // Hide all sections by default
        $('.overnight_stay, .day_tour, .place_reservation').addClass('d-none');

        var selectedOption = $(this).val();
        var selectedDate = moment().startOf('day');

        // Initialize the time picker
        $('.reservationtime').daterangepicker({
            timePicker: false,
            startDate: selectedDate,
            endDate: selectedDate,
            locale: {
                format: 'MM/DD/YYYY'
            },
            autoApply: true,
            drops: 'up',
            isInvalidDate: function(date) {
                // Disable past dates or Sundays (date.day() === 0)
                if (date.isBefore(selectedDate)) {
                    return true;
                }
            }
        }).on('show.daterangepicker', function(ev, picker) {
            originalStartDate = picker.startDate.clone(); 
            originalEndDate = picker.endDate.clone();
        }).on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
            var endDate = picker.endDate.format('YYYY-MM-DD HH:mm:ss');

            $('.btnSubmit').removeAttr('disabled');
                
            // Set hidden input values
            $('#checkin_date').val(startDate);
            $('#checkout_date').val(endDate);
            $('#checkin_date_dt').val(startDate);
            $('#checkout_date_dt').val(endDate);
            $('#checkin_date_pr').val(startDate);
            $('#checkout_date_pr').val(endDate);
        });
        
        if (selectedOption === '0') {
            $('.reservationtime').parent().removeClass('d-none');
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
            $('.reservationtime').parent().addClass('d-none');
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

            var startDate = moment().startOf('day').add(1, 'hours').format('YYYY-MM-DD HH:mm:ss');
            var endDate = moment().startOf('day').add(23, 'hours').format('YYYY-MM-DD HH:mm:ss');

            $('#checkin_date_dt').val(startDate);
            $('#checkout_date_dt').val(endDate);
            $('#checkin_date_pr').val(startDate);
            $('#checkout_date_pr').val(endDate);
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
                          for (let i = 0; i < data.datav3.length; i++) {
                              events.push({
                                title: data.datav3[i].accomodation_name + ' ' + data.datav3[i].accomodation_taken +'/'+data.datav3[i].accomodation_qty,
                                start:    data.datav3[i].checkin_date,
                                end:  data.datav3[i].checkout_date,
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
                              // Disable past dates or Sundays (date.day() === 0)
                              if (date.isBefore(selectedDate)) {
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

    var roomTypes = [];
    var selectedRoomTypesText = [];
    var selectedTourTypesText = [];
    var selectedGroupTypesText = [];
    var selectedTypesText = [];
    $('#quickForm').submit(function(event) {
        event.preventDefault();

        var selectedOption = $('.booking_option').val();
        var bookingDetails = ''; // To store details dynamically
        var optionText = '';
       
       

        var name = $('#name').val();
        var email = $('#email').val();
        var address = $('#address').val();
        var contactNo = $('#contact_no').val();
        var noOfAdults = $('#no_of_adults').val();
        var noOfChildren = $('#no_of_children').val();

        var tour_type = $('#tour_type').val();
        var dt_name = $('#dt_name').val();
        var group_type = $('#group_type').val();
        var room_type_pr = $('#room_type_pr').val();

        selectedRoomTypesText = [];
        roomTypes = [];
        selectedTourTypesText = [];
        selectedGroupTypesText = [];
        selectedTypesText = [];

        let totalCapacity = 0;
        let validationFailed = false;

        // Collect room types and validate capacities
        $('.class_room_type').each(function() {
            const roomId = $(this).val();
            var roomText = $(this).find('option:selected').text(); // Get selected room text

            if (roomText) {
                selectedRoomTypesText.push(roomText); // Store room text
            }

            if (roomId) {
                roomTypes.push(roomId); // Store room type IDs

                // Fetch room capacity via AJAX (synchronously)
                $.ajax({
                    url: '/room-capacity/' + roomId,
                    type: 'GET',
                    async: false,
                    success: function(response) {
                        if (response.capacity) {
                            totalCapacity += response.capacity;
                        }
                    },
                    error: function() {
                        alert('Could not fetch room capacity. Please try again.');
                        validationFailed = true;
                    }
                });
            }
        });
        
        if (selectedOption === '0') {
            const adults = parseInt($('#no_of_adults').val()) || 0;
            const children = parseInt($('#no_of_children').val()) || 0;
            const totalPersons = adults + children;

           

            if (validationFailed) return;
            if (totalCapacity < totalPersons) {
                showValidationModal(`The total capacity of the selected rooms is ${totalCapacity}, but you have selected ${totalPersons} persons.`);
                return;
            }

            $('#confirm_tour_types').addClass('d-none');
            $('#confirm_group_name').addClass('d-none');
            $('#confirm_group_types').addClass('d-none');
            $('#confirm_types').addClass('d-none');

            optionText = 'Overnight Stay';
            bookingDetails += `<p><strong>Room Type:</strong> ${selectedRoomTypesText.join(', ')}</p>`;
            bookingDetails += `<p><strong>Check-in Date:</strong> ${$('#checkin_date').val()}</p>`;
            bookingDetails += `<p><strong>Check-out Date:</strong> ${$('#checkout_date').val()}</p>`;
            bookingDetails += `<p><strong>No. of Adults:</strong> ${$('#no_of_adults').val()}</p>`;
            bookingDetails += `<p><strong>No. of Children:</strong> ${$('#no_of_children').val()}</p>`;
        } else if (selectedOption === '1') {
            optionText = 'Day Tour';
            selectedTourTypesText.push($('#tour_type').val().replace("_",""))
            selectedGroupTypesText.push($('#group_type').val().replace("_",""))
            selectedTypesText.push($('#room_type_pr').val().replace("_",""))


            $('#confirm_tour_types').removeClass('d-none');
            $('#confirm_group_name').removeClass('d-none');
            $('#confirm_group_types').removeClass('d-none');
            $('#confirm_types').removeClass('d-none');

            bookingDetails += `<p><strong>Tour Name:</strong> ${$('#dt_name').val()}</p>`;
            bookingDetails += `<p><strong>Tour Type:</strong> ${$('#tour_type').val()}</p>`;
            bookingDetails += `<p><strong>Group Type:</strong> ${$('#group_type').val()}</p>`;
            bookingDetails += `<p><strong>Room Type:</strong> ${$('#room_type').val()}</p>`;
            bookingDetails += `<p><strong>No. of Persons:</strong> ${$('#no_of_persons').val()}</p>`;
            bookingDetails += `<p><strong>Tour Types:</strong> ${$('#tour_type').val()}</p>`;
            bookingDetails += `<p><strong>Group Name:</strong> ${$('#dt_name').val()}</p>`;
            bookingDetails += `<p><strong>Group Types:</strong> ${$('#group_type').val()}</p>`;
            bookingDetails += `<p><strong>Types:</strong> ${$('#room_type_pr').val()}</p>`;
            bookingDetails += `<p><strong>Check-in Date:</strong> ${$('#checkin_date_dt').val()}</p>`;
            bookingDetails += `<p><strong>Check-out Date:</strong> ${$('#checkout_date_dt').val()}</p>`;
        }
        // else if (selectedOption === '2') {
        //     optionText = 'Place Reservation';
        //     selectedRoomTypesText.push($('#room_type_pr').val().replace("_",""))
        //     bookingDetails += `<p><strong>Room Type:</strong> ${$('#room_type_pr').val()}</p>`;
        //     bookingDetails += `<p><strong>No. of Cottages:</strong> ${$('#no_of_cottages').val()}</p>`;
        //     bookingDetails += `<p><strong>Check-in Date:</strong> ${$('#checkin_date_pr').val()}</p>`;
        //     bookingDetails += `<p><strong>Check-out Date:</strong> ${$('#checkout_date_pr').val()}</p>`;
        // }

      
        // Update confirmation modal
        $('#selectedOptionText').text(optionText);
        $('#confirm_name').text(name);
        $('#confirm_email').text(email);
        $('#confirm_address').text(address);
        $('#confirm_contact_no').text(contactNo);
        $('#confirm_no_of_adults').text(noOfAdults);
        $('#confirm_no_of_children').text(noOfChildren);
        $('#confirm_tour_types').text(selectedTourTypesText.join(', '));
        $('#confirm_group_name').text(dt_name);
        $('#confirm_group_types').text(selectedGroupTypesText.join(', '));
        $('#confirm_types').text(selectedTypesText.join(', '));
        $('#confirm_room_types').text(selectedRoomTypesText.join(', '));
        $('#bookingDetails').html(bookingDetails);

        // Show the review modal
        $('#bookingReviewModal').modal('show');
    });

    $('body').on('change', '.class_room_type', function () {
        const roomId = $(this).val();
        const parentDiv = $(this).closest('.input-group');
        const roomImage = parentDiv.find('.room-image');

        if (roomId) {
            $.ajax({
                url: '/get-room-details/' + roomId,
                type: 'GET',
                success: function (response) {
                    if (response.image) {
                        roomImage.attr('src', response.image).show();
                        roomImage.attr('data-id', roomId)
                    } else {
                        roomImage.attr('src', '/images/default-image.png').show();
                    }
                },
                error: function (xhr) {
                    console.error('Error fetching room details:', xhr);
                    roomImage.attr('src', '/images/default-image.png').show();
                }
            });
        }
    }).on('click', '.clickable-room-image', function () {
        const roomId = $(this).data('id');

        if (roomId) {
            $.ajax({
                url: '/get-room-details/' + roomId,
                type: 'GET',
                success: function (response) {
                    $('#modalRoomImage').attr('src', response.image || '/images/default-image.png');
                    $('#modalRoomType').text(response.type || 'Unknown');
                    $('#modalRoomDescription').text(response.description || 'No description available.');
                    $('#modalRoomCapacity').text(response.capacity || 'N/A');
                    $('#modalRoomAvailability').text(response.availability || 'N/A');

                    $('#roomDetailsModal').modal('show');
                },
                error: function (xhr) {
                    console.error('Error fetching room details:', xhr);
                    alert('Failed to load room details. Please try again later.');
                }
            });
        }
    });


    // Confirm booking and submit via AJAX
    $('.btnConfirmBooking').click(function() {
        $('.btnConfirmBooking').attr('disabled','disabled');
        $('.btnConfirmBooking').text('Loading...');
        if (selectedOptionText.textContent == 'Overnight Stay'){
            $.ajax({
                url: "{{ route('bookings.store') }}",
                type: "POST",
                data: {
                    'name': $('#name').val(),
                    'email': $('#email').val(),
                    'address': $('#address').val(),
                    'contact_no': $('#contact_no').val(),
                    'no_of_adults': $('#no_of_adults').val(),
                    'no_of_children': $('#no_of_children').val(),
                    'boooking_status': $('#boooking_status').val(),
                    'checkin_date': $('#checkin_date').val(),
                    'checkout_date': $('#checkout_date').val(),
                    'accomodation_id': roomTypes
                },
                success: function(response) {
                    // Handle success
                },
                error: function(error) {
                    console.log(error);
                }
            });

            $.ajax({
                url: "{{ route('bookings.overnight_stay') }}",
                type: "POST",
                data: {
                    'email': $('#email').val(),
                    'room_type': roomTypes, // Pass room type IDs
                    'checkin_date': $('#checkin_date').val(),
                    'checkout_date': $('#checkout_date').val(),
                    'room_type_text': selectedRoomTypesText // Pass room type names
                },
                success: function(response) {
                    $('#eventModal').modal('hide');
                    $('#bookingReviewModal').modal('hide');
                    loadCalendar();
                    $('#bookingMessage').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }else if (selectedOptionText.textContent == 'Day Tour'){
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
                'checkout_date'   : $('#checkout_date_dt').val(),
                'accomodation_id': roomTypes
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
                'room_type'       :roomTypes,
                'no_of_persons'   :$('#no_of_persons').val(),
                'checkin_date'    :$('#checkin_date_dt').val(),
                'checkout_date'   :$('#checkout_date_dt').val()
              },
              success: function(response) {
                  $('#eventModal').modal('hide');
                  $('#bookingReviewModal').modal('hide');
                  loadCalendar();
                  $('#bookingMessage').modal('show');
              },
              error: function(error) {
                  console.log(error)
              }
          });
        }
        // else if (selectedOptionText.textContent == 'Place Reservation'){
        //     $('.place_reservation').removeClass('d-none');
        //     $.ajax({
        //       url: "{{ route('bookings.store') }}",
        //       type: "POST",
        //       data: {
        //         'name'            :$('#name').val(),
        //         'email'           :$('#email').val(),
        //         'address'         :$('#address').val(),
        //         'contact_no'      :$('#contact_no').val(),
        //         'no_of_adults'    :$('#no_of_adults').val(),
        //         'no_of_children'  :$('#no_of_children').val(),
        //         'boooking_status' :$('#boooking_status').val(),
        //         'checkin_date'    : $('#checkin_date_pr').val(),
        //         'checkout_date'   : $('#checkout_date_pr').val()
        //       },
        //       success: function(response) {
                  
        //       },
        //       error: function(error) {
        //           console.log(error)
        //       }
        //   });

        //   $.ajax({
        //       url: "{{ route('bookings.place_reservation') }}",
        //       type: "POST",
        //       data: {
        //         'email'           :$('#email').val(),
        //         'room_type'       :$('#room_type_pr').val(),
        //         'no_of_cottages'  :$('#no_of_cottages').val(),
        //         'checkin_date'    :$('#checkin_date_pr').val(),
        //         'checkout_date'   :$('#checkout_date_pr').val()
        //       },
        //       success: function(response) {
        //           $('#eventModal').modal('hide');
        //           $('#bookingReviewModal').modal('hide');
        //           loadCalendar();
        //           $('#bookingMessage').modal('show');
        //       },
        //       error: function(error) {
        //           console.log(error)
        //       }
        //   });

        //     optionText = 'Place Reservation';
        //     bookingDetails += `<p><strong>Room Type:</strong> ${$('#room_type_pr').val()}</p>`;
        //     bookingDetails += `<p><strong>No. of Cottages:</strong> ${$('#no_of_cottages').val()}</p>`;
        //     bookingDetails += `<p><strong>Check-in Date:</strong> ${$('#checkin_date_pr').val()}</p>`;
        //     bookingDetails += `<p><strong>Check-out Date:</strong> ${$('#checkout_date_pr').val()}</p>`;
        // }
       
    });

    //Booking Status Day Tour
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
        }else if (selectedOption === 'place_reservation') {
            $('.place_reservation').removeClass('d-none');
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
                <img src="{{ asset('images/default-image.png') }}" class="room-image thumbnail clickable-room-image" style="width: 150px; height: 100px; margin-right: 15px;" data-id=""/>
                <select name="room_type" class="class_room_type form-control">
                    <option selected value="">Select option</option>
                    @foreach (App\Models\Accomodation::getAccomodationOvernightStay() as $accommodation)
                        @php
                            $booking = App\Models\BookingModel::getBookingListv3()->firstWhere('accomodation_name', $accommodation->type);
                            $taken = $booking ? $booking->accomodation_taken : 0;
                            $isDisabled = ($taken >= $accommodation->qty);
                        @endphp
                        
                        <option value="{{ $accommodation->id }}"
                            data-taken="{{ $taken }}"
                            data-qty="{{ $accommodation->qty }}"
                            {{ $isDisabled ? 'disabled' : '' }}>
                            {{ $accommodation->type }} &nbsp;&nbsp;
                            (Capacity: {{ $accommodation->capacity }}-pax)
                            &nbsp;&nbsp;
                            {{ $isDisabled ? 'Fully Booked' : 'Room availability: ' . ($accommodation->qty - $taken) . ' room(s) left' }}
                        </option>
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
