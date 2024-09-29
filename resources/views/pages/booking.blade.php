@extends('layouts.app', [
'class' => '',
'elementActive' => 'home'
])
@section('content')
<style>
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    header {
      background-color: #222;
      padding: 5px 0;
    }

    .head_container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo img {
      max-width: 150px;
    }

    .nav a {
      color: #fff;
      text-decoration: none;
      padding: 5px 10px;
    }

    .nav a:hover {
      background-color: #555;
      border-radius: 5px;
    }

    .hambuger {
      display: none;
    }

    .about {
      color: #fff;
      background-color: #444;
      padding: 50px 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

</style>

<div class="background-overlay" id="background-overlay"></div>
  <div class="overlay"></div>
  <!-- Header -->
  @include('pages.header')

  <section class="about" id="about">
    <div class="container">
      <div id="calendar"></div>
    </div>
  </section>

  <!-- Modal Form for Event Creation -->
  <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="eventModalLabel">Book</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="quickForm">
            <div class="row">
                <div class="form-group col-6">
                  <label for="name">Name:</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group col-6">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="row">
              <div class="form-group col-6">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
              </div>
              <div class="form-group col-6">
                <label for="contact">Contact No.:</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" required data-inputmask='"mask": "(639) 999999999"' data-mask>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-6">
                <label for="adults">Number of Adults:</label>
                <input type="number" class="form-control" id="no_of_adults" name="no_of_adults" required min="0" max="99">
              </div>
              <div class="form-group col-6">
                <label for="children">Number of Children:</label>
                <input type="number" class="form-control" id="no_of_children" name="no_of_children" required min="0" max="99">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-12">
                <label for="children">Booking status:</label>
                <select required class="booking_option form-control" name="boooking_status" id="boooking_status">
                  <option selected value="">Select option</option>
                  <option value="0">Overnight Stay</option>
                  <option value="1">Day Tour</option>
                  <option value="2">Place Reservation</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12 overnight_stay d-none">
                <div class="form-group" id="room-container">
                  <label for="children">Room Type:</label>
                  <div class="input-group date">
                      <select name="room_type" id="room_type" class="class_room_type form-control">
                          <option selected value="">Select option</option>
                          @foreach (App\Models\BookingOvernightStayModel::ROOM_TYPE as $key => $type)
                              <option value="{{$key}}">{{$type}}</option>
                          @endforeach
                      </select>
                      <div class="input-group-append">
                          <button type="button" class="input-group-text btn btn-sm btn-info btn-add">
                              <i class="fas fa-plus"></i>
                          </button>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-12 overnight_stay d-none">
                <div class="form-group">
                  <label for="children">Date:</label>
                  <input type="text" class="reservationtime form-control float-right" id="reservationtimeOS">
                </div>
                <div class="form-group d-none">
                  <label for="children">Date:</label>
                  <input type="datetime" class="form-control float-right" id="checkin_date" name="checkin_date">
                  <input type="datetime" class="form-control float-right" id="checkout_date" name="checkout_date">
                </div>
              </div>
              <div class="col-12 day_tour d-none">
                <div class="form-group">
                  <label for="children">Tour Type:</label>
                  <select name="tour_type" id="tour_type" class="room_type form-control">
                    <option selected value="">Select option</option>
                    @foreach (App\Models\BookingDayTourModel::TOUR_TYPE as $key => $type)
                      <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group dt_name_class d-none">
                  <label for="name">Name:</label>
                  <input type="text" class="form-control" id="dt_name" name="name">
                </div>
                <div class="form-group no_person d-none">
                  <label for="adults">Number of Persons:</label>
                  <input type="number" class="form-control" id="no_of_persons" name="no_of_persons" min="0">
                </div>
                <div class="form-group gt d-none">
                  <label for="children">Group Type:</label>
                  <select name="group_type" id="group_type" class="room_type form-control">
                    <option selected value="">Choose option</option>
                    @foreach (App\Models\BookingDayTourModel::GROUP_TYPE as $key => $type)
                      <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="children">Date:</label>
                  <input type="text" class="reservationtime form-control float-right" id="reservationtimeDT">
                </div>
                <div class="form-group d-none">
                  <label for="children">Date:</label>
                  <input type="datetime" class="form-control float-right" id="checkin_date_dt" name="checkin_date">
                  <input type="datetime" class="form-control float-right" id="checkout_date_dt" name="checkout_date">
                </div>
              </div>
              <div class="col-12 place_reservation d-none">
                <div class="form-group">
                  <label for="children">Type:</label>
                  <select name="room_type" id="room_type_pr" class="room_type_pr form-control">
                    <option selected value="">Select option</option>
                    @foreach (App\Models\BookingPlaceReservationModel::ROOM_TYPE as $key => $type)
                      <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group no_of_cottages d-none">
                  <label for="adults">Number of Cottage:</label>
                  <input type="number" class="form-control" id="no_of_cottages" name="no_of_cottages" min="0">
                </div>
                <div class="form-group">
                  <label for="children">Date:</label>
                  <input type="text" class="reservationtime form-control float-right" id="reservationtimePR">
                </div>
                <div class="form-group d-none">
                  <label for="children">Date:</label>
                  <input type="datetime" class="form-control float-right" id="checkin_date_pr" name="checkin_date">
                  <input type="datetime" class="form-control float-right" id="checkout_date_pr" name="checkout_date">
                </div>
              </div>
            </div>
            <input type="hidden" id="eventDate" name="date">
            <hr />
            <div style="display: flex; align-items:center" class="mt-2">
              <button type="submit" class="mr-2 btn btn-primary btnSubmit">
                <span class="fas fa-sync-alt d-none" role="status" aria-hidden="true"></span>
                Save</button>
              <span class="errMsg text-danger d-none">All fields are required</span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="bookingMessage" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="eventModalLabel">Successful</h5>
        </div>
        <div class="modal-body">
         <p>Your reservation details have been saved. Kindly check your email for the confirmation of your request. Thank you for choosing Goducate!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btnClose">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection

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
                          for (let i = 0; i < data.data.length; i++) {
                              events.push({
                                  title: "Unavailable",
                                  start: data.data[i].checkin_date,
                                  end: data.data[i].checkout_date
                              });
                              // Store bookings for time disabling
                              existingBookings.push({
                                  start: data.data[i].checkin_date,
                                  end: data.data[i].checkout_date
                              });
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


    $('#quickForm').submit(function(event) {
      
        event.preventDefault();
        
        var selectedOption = $('.booking_option').val();
        var $btn = $(this);

        $('.btnSubmit').attr('disabled', 'disabled');
        $btn.find('.fa-sync-alt').removeClass('d-none');

        if (selectedOption === '0') {
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
                'boooking_status' :$('#boooking_status').val()
              },
              success: function(response) {
                  
              },
              error: function(error) {
                  console.log(error)
              }
          });

          var roomTypes = [];
          $('.class_room_type').each(function(){
              roomTypes.push($(this).val());
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
                'boooking_status' :$('#boooking_status').val()
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
                'boooking_status' :$('#boooking_status').val()
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
                    @foreach (App\Models\BookingOvernightStayModel::ROOM_TYPE as $key => $type)
                        <option value="{{$key}}">{{$type}}</option>
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

