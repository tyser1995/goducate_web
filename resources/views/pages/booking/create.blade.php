@extends('layouts.app', [
'class' => '',
'elementActive' => 'booknow'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card  shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 h3_title">Booking</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('booking.index') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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
                                  <option value="2" hidden>Place Reservation</option>
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
                                  <label for="name">Group Name:</label>
                                  <input type="text" class="form-control" id="dt_name" name="name">
                                </div>
                                <div class="form-group no_person d-none" hidden>
                                  <label for="adults">Number of Persons:</label>
                                  <input type="number" class="form-control" id="no_of_persons" name="no_of_persons" min="0" value="0">
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
        
          <div id="validationModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="validationMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
          </div>
        
          <!-- Modal for Booking Details Review -->
        <div class="modal fade" id="bookingReviewModal" tabindex="-1" role="dialog" aria-labelledby="bookingReviewModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="bookingReviewModalLabel">Review Your Booking Details</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <h6>Selected Option: <span id="selectedOptionText"></span></h6>
                      <div id="bookingDetails" class="d-none"></div>
                      <p><strong>Name:</strong> <span id="confirm_name"></span></p>
                      <p><strong>Email:</strong> <span id="confirm_email"></span></p>
                      <p><strong>Address:</strong> <span id="confirm_address"></span></p>
                      <p><strong>Contact No.:</strong> <span id="confirm_contact_no"></span></p>
                      <p><strong>Number of Adults:</strong> <span id="confirm_no_of_adults"></span></p>
                      <p><strong>Number of Children:</strong> <span id="confirm_no_of_children"></span></p>
                      <p><strong>Room Types:</strong> <span id="confirm_room_types"></span></p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit</button>
                      <button type="button" class="btn btn-primary btnConfirmBooking">Confirm Booking</button>
                  </div>
              </div>
          </div>
        </div>

    </div>
</div>
@endsection

@include('pages.booking.script')
@push('scripts')
<script>

</script>
@endpush