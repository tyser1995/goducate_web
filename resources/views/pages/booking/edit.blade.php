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
                                <h3 class="mb-0 h3_title">Booking Info</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('booking.index') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" autocomplete="off" action="{{route('booking.update',$bookings)}}">
                            @csrf
                            @method('put')
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                    <h4>Details</h4>
                                    <div class="form-group row">
                                       <div class="col-2">
                                            <p for="name">Name:</p>
                                       </div>
                                       <div class="col-4">
                                            <p for="name">{{old('name',$bookings->name)}}</p>
                                        </div>
                                        <div class="col-2">
                                            <p for="email">Email:</p>
                                       </div>
                                       <div class="col-4">
                                            <p for="email">{{old('email',$bookings->email)}}</p>
                                        </div>
                                        <div class="col-2">
                                            <p for="address">Address:</p>
                                       </div>
                                       <div class="col-4">
                                            <p for="address">{{old('address',$bookings->address)}}</p>
                                        </div>
                                        <div class="col-2">
                                            <p for="contact_no">Contact No.:</p>
                                       </div>
                                       <div class="col-4">
                                            <p for="contact_no">{{old('contact_no',$bookings->contact_no)}}</p>
                                        </div>
                                        <div class="col-2">
                                            <p for="no_of_adults">Number of Adults:</p>
                                       </div>
                                       <div class="col-4">
                                            <p for="no_of_adults">{{old('no_of_adults',$bookings->no_of_adults)}}</p>
                                        </div>
                                        <div class="col-2">
                                          <p for="no_of_children">Number of Children:</p>
                                     </div>
                                     <div class="col-4">
                                          <p for="no_of_children">{{old('no_of_children',$bookings->no_of_children)}}</p>
                                      </div>
                                    </div>
                                    <h4>Booking Status</h4>
                                    <?php
                                        $overnight_stay = \App\Models\BookingOvernightStayModel::getOvernightStayByEmail($bookings->email);

                                        $day_tour = \App\Models\BookingDayTourModel::getDayTourByEmail($bookings->email);

                                        $place_reservation = \App\Models\BookingPlaceReservationModel::getPlaceReservationByEmail($bookings->email);
                                    ?>
                                    @if ($overnight_stay->count() > 0)
                                        <p>{{ __('Overnight Stay') }}</p>
                                        @php
                                            $currentDateRange = null;
                                        @endphp
                                    
                                        @foreach ($overnight_stay as $value)
                                            @php
                                                $checkin = \Carbon\Carbon::parse($value->checkin_date);
                                                $checkout = \Carbon\Carbon::parse($value->checkout_date);
                                                
                                                if ($checkin->isSameDay($checkout)) {
                                                    $formattedDate = $checkin->format('l M d, Y H:i') . ' - ' . $checkout->format('H:i');
                                                } elseif ($checkin->isSameMonth($checkout) && $checkin->isSameYear($checkout)) {
                                                    $formattedDate = $checkin->format('l M d') . '-' . $checkout->format('d, Y H:i') . ' - ' . $checkout->format('H:i');
                                                } elseif ($checkin->isSameYear($checkout)) {
                                                    $formattedDate = $checkin->format('l M d H:i') . ' - ' . $checkout->format('M d, Y H:i');
                                                } else {
                                                    $formattedDate = $checkin->format('l M d, Y H:i') . ' - ' . $checkout->format('M d, Y H:i');
                                                }
                                            @endphp
                                            
                                            @if ($currentDateRange !== $formattedDate)
                                                @if ($currentDateRange !== null)
                                                    <hr/>
                                                @endif
                                                
                                                <p>{{ $formattedDate }}</p>
                                        
                                                @php
                                                    $currentDateRange = $formattedDate;
                                                @endphp
                                            @endif
                                        
                                            <?php 
                                          
                                                $room_types = \App\Models\Accomodation::getAccomodationOvernightStayName($value->room_type);
                                            ?>
                                            <span>{{ $room_types }}</span><br/>
                                        @endforeach
                                    
                                    @elseif ($day_tour->count() > 0)
                                        <p>{{ __('Day Tour') }}</p>
                                        @foreach ($day_tour as $value)
                                            @php
                                                $checkin = \Carbon\Carbon::parse($value->checkin_date);
                                                $checkout = \Carbon\Carbon::parse($value->checkout_date);
                                                
                                                
                                                if ($checkin->isSameDay($checkout)) {
                                                    $formattedDate = $checkin->format('l M d, Y H:i') . ' - ' . $checkout->format('H:i');
                                                }
                                                elseif ($checkin->isSameMonth($checkout) && $checkin->isSameYear($checkout)) {
                                                    $formattedDate = $checkin->format('l M d') . '-' . $checkout->format('d, Y H:i') . ' - ' . $checkout->format('H:i');
                                                }
                                                elseif ($checkin->isSameYear($checkout)) {
                                                    $formattedDate = $checkin->format('l M d H:i') . ' - ' . $checkout->format('M d, Y H:i');
                                                }
                                                else {
                                                    $formattedDate = $checkin->format('l M d, Y H:i') . ' - ' . $checkout->format('M d, Y H:i');
                                                }
                                            @endphp

                                            <span>{{ $value->tour_type }}</span> &nbsp;
                                            <span>{{ $value->group_type }}</span> &nbsp;
                                            <span>{{ $value->no_of_persons }}</span> &nbsp;
                                            <span>{{ $formattedDate }}</span><br/>
                                        @endforeach
                                    @elseif ($place_reservation->count() > 0)
                                        <p>{{ __('Place Reservation') }}</p>   
                                        @foreach ($place_reservation as $value)
                                            @php
                                                $checkin = \Carbon\Carbon::parse($value->checkin_date);
                                                $checkout = \Carbon\Carbon::parse($value->checkout_date);
                                                
                                                
                                                if ($checkin->isSameDay($checkout)) {
                                                    $formattedDate = $checkin->format('l M d, Y H:i') . ' - ' . $checkout->format('H:i');
                                                }
                                                elseif ($checkin->isSameMonth($checkout) && $checkin->isSameYear($checkout)) {
                                                    $formattedDate = $checkin->format('l M d') . '-' . $checkout->format('d, Y H:i') . ' - ' . $checkout->format('H:i');
                                                }
                                                elseif ($checkin->isSameYear($checkout)) {
                                                    $formattedDate = $checkin->format('l M d H:i') . ' - ' . $checkout->format('M d, Y H:i');
                                                }
                                                else {
                                                    $formattedDate = $checkin->format('l M d, Y H:i') . ' - ' . $checkout->format('M d, Y H:i');
                                                }
                                            @endphp
                                    
                                            <span>{{ $value->room_type }}</span> &nbsp;
                                            <span>{{ $value->no_of_cottages }}</span> &nbsp;
                                            <span>{{ $value->no_of_persons }}</span> &nbsp;
                                            <span>{{ $formattedDate }}</span><br/>
                                        @endforeach
                                    @else
                                        <span>{{__('No data found.')}}</span>
                                    @endif
                                    
                                    <div class="form-group">
                                        <label for="name">Status</label>
                                        <select required class="form-control" name="status" id="status"  {{$bookings->status == "approved" ? 'disabled' : ''}}>
                                            <option value="">Select option</option>
                                            <option value="approved" {{ $bookings->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="cancel" {{ $bookings->status == 'cancel' ? 'selected' : '' }}>Cancel Booking</option>
                                        </select>
                                    </div>
                      
                                <div class="">
                                    <button type="submit" class="btn btn-success mt-4" {{$bookings->status == "approved" ? 'hidden' : ''}}>{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('employees.script')
@push('scripts')
<script>

</script>
@endpush