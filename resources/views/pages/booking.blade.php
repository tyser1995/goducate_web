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
              <input type="text" class="form-control" id="contact_no" name="contact_no" required>
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
              <select class="booking_option form-control" name="boooking_status" id="boooking_status">
                <option hidden selected disabled>Select option</option>
                <option value="0">Overnight Stay</option>
                <option value="1">Day Tour</option>
                <option value="2">Place Reservation</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12 overnight_stay d-none">
              <form id="osForm">
                @csrf
                <div class="form-group">
                  <label for="children">Room Type:</label>
                  <select name="room_type" id="room_type" class="room_type form-control">
                    <option hidden selected disabled>Select option</option>
                    @foreach (App\Models\BookingOvernightStayModel::ROOM_TYPE as $key => $type)
                      <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="children">Date:</label>
                  <input type="text" class="reservationtime form-control float-right">
                </div>
                <div class="form-group d-none">
                  <label for="children">Date:</label>
                  <input type="datetime" class="form-control float-right" id="checkin_date" name="checkin_date">
                  <input type="datetime" class="form-control float-right" id="checkout_date" name="checkout_date">
                </div>
              </form>
            </div>
            <div class="col-12 day_tour d-none">
              <form id="dtForm">
                @csrf
                <div class="form-group">
                  <label for="children">Tour Type:</label>
                  <select name="tour_type" id="tour_type" class="room_type form-control">
                    <option hidden selected disabled>Select option</option>
                    @foreach (App\Models\BookingDayTourModel::TOUR_TYPE as $key => $type)
                      <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" class="form-control" id="dt_name" name="name" required>
                </div>
                <div class="form-group no_person d-none">
                  <label for="adults">Number of Persons:</label>
                  <input type="number" class="form-control" id="no_of_persons" name="no_of_persons" required min="0" disabled>
                </div>
                <div class="form-group gt d-none">
                  <label for="children">Group Type:</label>
                  <select name="group_type" id="group_type" class="room_type form-control" disabled>
                    <option selected disabled hidden>Choose option</option>
                    @foreach (App\Models\BookingDayTourModel::GROUP_TYPE as $key => $type)
                      <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="children">Date:</label>
                  <input type="text" class="reservationtime form-control float-right">
                </div>
                <div class="form-group d-none">
                  <label for="children">Date:</label>
                  <input type="datetime" class="form-control float-right" id="checkin_date_dt" name="checkin_date">
                  <input type="datetime" class="form-control float-right" id="checkout_date_dt" name="checkout_date">
                </div>
              </form>
            </div>
            <div class="col-12 place_reservation d-none">
              <h1 class="text-dark">Place Reservation</h1>
            </div>
          </div>
          <input type="hidden" id="eventDate" name="date">
          <button type="button" id="btnSubmit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>

    $('.book_now')[0].innerHTML = "Booking";
    
    $('.booking_option').change(function (e) { 
        e.preventDefault();
        // Hide all sections by default
        $('.overnight_stay, .day_tour, .place_reservation').addClass('d-none');

        // Get the selected option value
        var selectedOption = $(this).val();
        // Show the corresponding section based on the selected option
        if (selectedOption === '0') {
            $('.overnight_stay').removeClass('d-none');
        } else if (selectedOption === '1') {
            $('.day_tour').removeClass('d-none');
        } else if (selectedOption === '2') {
            $('.place_reservation').removeClass('d-none');
        }
    });

    loadCalendar();

    function loadCalendar() {
      document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var today = new Date().toISOString().split('T')[0];

          var calendar = new FullCalendar.Calendar(calendarEl, {
              selectable: true,
              initialView: 'dayGridMonth',
              validRange: {
                  start: today 
              },
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
                          }
                          successCallback(events);
                      },
                      error: function() {
                          failureCallback();
                      }
                  });
              },
              dateClick: function(info) {
                  if (info.dateStr >= today) {
                      $('#eventModalLabel')[0].innerHTML = "Booking date " + info.dateStr;
                     
                      var selectedDate = moment(info.dateStr).format('MM/DD/YYYY hh:mm A');
                      $('.reservationtime').daterangepicker({
                          timePicker: true,
                          timePickerIncrement: 30,
                          startDate: selectedDate, 
                          endDate: selectedDate,
                          locale: {
                              format: 'MM/DD/YYYY hh:mm A'
                          },
                          autoApply: true,
                          drops: 'up',
                          isInvalidDate: function(date) {
                              var today = moment(info.dateStr).startOf('day');
                              return date.isBefore(today) || date.day() === 0;
                          }
                      }).on('apply.daterangepicker', function(ev, picker) {
                          // Format the selected dates
                          var startDate = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
                          var endDate = picker.endDate.format('YYYY-MM-DD HH:mm:ss');

                          // Set values in hidden inputs for form submission
                          $('#checkin_date').val(startDate);
                          $('#checkout_date').val(endDate);
                          $('#checkin_date_dt').val(startDate);
                          $('#checkout_date_dt').val(endDate);
                      });


                      var formattedDate = moment(info.dateStr).format('YYYY-MM-DD HH:mm:ss');
                      $('#checkin_date').val(formattedDate);
                      $('#checkout_date').val(formattedDate);
                      $('#checkin_date_dt').val(formattedDate);
                      $('#checkout_date_dt').val(formattedDate);


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


    $('#btnSubmit').on('click', function(event) {
        event.preventDefault();
        var selectedOption = $('.booking_option').val();

        $.ajax({
            url: "{{ route('bookings.store') }}",
            type: "POST",
            data: {
              'name'            :$('#dt_name').val(),
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
                alert('Error saving event');
            }
        });

        if (selectedOption === '0') {
          $.ajax({
              url: "{{ route('bookings.overnight_stay') }}",
              type: "POST",
              data: {
                'room_type'       :$('#room_type').val(),
                'checkin_date'    :$('#checkin_date').val(),
                'checkout_date'    :$('#checkout_date').val()
              },
              success: function(response) {
                  $('#eventModal').modal('hide');
                  loadCalendar();
              },
              error: function(error) {
                  alert('Error saving event');
              }
          });
        } else if (selectedOption === '1') {
          $.ajax({
              url: "{{ route('bookings.day_tour') }}",
              type: "POST",
              data: {
                'name'            :$('#name').val(),
                'tour_type'       :$('#tour_type').val(),
                'group_type'      :$('#group_type').val(),
                'no_of_persons'   :$('#no_of_persons').val(),
                'checkin_date'    :$('#checkin_date').val(),
                'checkout_date'   :$('#checkout_date').val()
              },
              success: function(response) {
                  $('#eventModal').modal('hide');
                  loadCalendar();
              },
              error: function(error) {
                  alert('Error saving event');
              }
          });
        } else if (selectedOption === '2') {
            $('.place_reservation').removeClass('d-none');
        }

        location.reload();
    });

    $('#tour_type').change(function (e) { 
        e.preventDefault();
        var selectedOption = $(this).val();
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
  </script>
@endpush

