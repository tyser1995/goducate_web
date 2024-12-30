@component('mail::message')
# {{ $details['title'] }}

{{ $details['body'] }}

@if($details['booking_status'] == "overnight_stay")
    @foreach ($details['reservation'] as $reservation)
    - **Room Type**: {{ $reservation->room_type ?? '' }}
        - **Check-in Date**: {{ date('Y-m-d', strtotime($reservation->checkin_date)) }}
        - **Check-out Date**: {{ date('Y-m-d', strtotime($reservation->checkout_date)) }}
        - **Status**: {{ $reservation->status }}
    @endforeach
@elseif($details['booking_status'] == "place_reservation")
    - **Room Type**: {{ $reservation->room_type ?? '' }}
    @if ($reservation->no_of_adults > 0)
        - **No of Adults**: {{ $reservation->no_of_adults }}
    @endif
    @if ($reservation->no_of_children > 0)
        - **No of Children**: {{ $reservation->no_of_children }}
    @endif
    
    - **Check-in Date**:  {{ date('Y-m-d', strtotime($reservation->checkin_date)) }}
    - **Check-out Date**:  {{ date('Y-m-d', strtotime($reservation->checkout_date)) }}
    - **Status**: {{ $reservation->status }}
@elseif($details['booking_status'] == "day_tour")
    {{-- @if ($reservation->tour_type == "team_building")
    - **Tour Type**: Team Building
        - **Name**: {{ $reservation->name ?? '' }}
        - **Group Type**: {{ $reservation->group_type ?? '' }}
    @else
    - **Tour Type**: Family Fun and Learning
        - **Name**: {{ $reservation->name ?? '' }}
        @if ($reservation->no_of_persons > 0)
            - **No of Persons**: {{ $reservation->no_of_persons }}
        @endif
    @endif --}}
    @foreach ($details['reservation'] as $reservation)
        - **Name**: {{ $reservation->name ?? '' }}
        - **Group Type**: {{ $reservation->group_type ?? '' }}

        - **Check-in Date**: {{ now()->format('Y-m-d') }}
        - **Check-out Date**:  {{ now()->format('Y-m-d') }}
        - **Status**: {{ $reservation->status ?? 'Pending' }}
    @endforeach
@endif
    - **Patrial Amount**: {{ $details['partial_amount'] ?? 0 }}
    - **Total Amount**:  {{ $details['total_amount'] ?? 0 }}

@component('mail::button',['url' => url('checkout/id=' . Hashids::encode($details['customer_id']))])
Click to payment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

