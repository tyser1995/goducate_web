<?php

namespace App\Services;

use App\Models\Accomodation;
use App\Models\BookingModel;
use App\Models\BookingOvernightStayModel;
use App\Models\BookingDayTourModel;
use App\Models\BookingPlaceReservationModel;
use App\Models\CustomerModel;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingService
{
    /**
     * Create a new booking, auto-creating the customer record if needed.
     */
    public function createBooking(array $data): array
    {
        $roomTypeIds = is_array($data['accomodation_id'])
            ? $data['accomodation_id']
            : [$data['accomodation_id']];

        $customer = CustomerModel::getCustomerByEmail($data['email']);
        $customerId = $customer
            ? $customer->id
            : $this->createCustomerFromBookingData($data)->id;

        $bookings = [];
        foreach ($roomTypeIds as $roomTypeId) {
            $room = Accomodation::find($roomTypeId);

            $bookings[] = BookingModel::create([
                'created_by_user_id'  => Auth::id() ?? 0,
                'customer_id'         => $data['customer_id'] ?? $customerId,
                'name'                => $data['name'],
                'email'               => $data['email'],
                'address'             => $data['address'],
                'contact_no'          => $data['contact_no'],
                'no_of_adults'        => $data['no_of_adults'],
                'no_of_children'      => $data['no_of_children'],
                'booking_status'      => $data['booking_status'],
                'checkin_date'        => $data['checkin_date'],
                'checkout_date'       => $data['checkout_date'],
                'accomodation_id'     => $roomTypeId,
                'accomodation_name'   => $room?->type,
                'accomodation_qty'    => $room?->qty,
                'accomodation_taken'  => 1,
                'status'              => 'pending',
            ]);
        }

        return $bookings;
    }

    /**
     * Approve a booking, update customer, create transaction, send email.
     */
    public function approveBooking(int $bookingId, array $data): BookingModel
    {
        $booking = BookingModel::findOrFail($bookingId);
        $booking->update(['status' => $data['status']]);

        $customer = $this->upsertCustomerFromBooking($booking, $data);

        if (!empty($data['walkInCheckbox']) && $data['walkInCheckbox'] === 'on') {
            Payment::create([
                'created_by_user_id' => Auth::id() ?? 0,
                'customer_id'        => $customer->id,
                'amount'             => $data['amount'] ?? 0,
                'attachment'         => $data['attachment'] ?? '',
                'payment_status'     => 'Full',
            ]);
        }

        $accommodation = Accomodation::getAccomodationById($booking->accomodation_id);

        Transaction::createTransaction([
            'email'              => $booking->email,
            'created_by_user_id' => Auth::id() ?? 0,
            'customer_id'        => $customer->id,
            'description'        => $accommodation?->type ?? '',
            'amount'             => $accommodation?->amount ?? 0,
        ]);

        $bookingTypeLabel = match ((int) $booking->booking_status) {
            0       => 'overnight_stay',
            1       => 'day_tour',
            2       => 'place_reservation',
            default => '',
        };

        Mail::to($booking->email)->send(new \App\Mail\SendApprovedMail([
            'title'          => 'Reservation Approved',
            'body'           => 'Your reservation has been approved. Thank you for choosing Goducate!',
            'reservation'    => $booking,
            'booking_status' => $bookingTypeLabel,
            'email'          => $booking->email,
        ]));

        return $booking;
    }

    /**
     * Delete all bookings belonging to a customer.
     */
    public function deleteByCustomerId(int $customerId): void
    {
        $customer = CustomerModel::findOrFail($customerId);
        BookingModel::where('email', $customer->email)->each(fn ($b) => $b->delete());
    }

    private function createCustomerFromBookingData(array $data): CustomerModel
    {
        return CustomerModel::create([
            'created_by_user_id' => Auth::id() ?? 0,
            'first_name'         => $data['name'] ?? '',
            'middle_name'        => '',
            'last_name'          => '',
            'email'              => $data['email'],
            'address'            => $data['address'],
            'contact_no'         => $data['contact_no'] ?? 0,
        ]);
    }

    private function upsertCustomerFromBooking(BookingModel $booking, array $data): CustomerModel
    {
        $attrs = [
            'created_by_user_id' => Auth::id() ?? 0,
            'first_name'         => $booking->name ?? '',
            'middle_name'        => '',
            'last_name'          => '',
            'email'              => $booking->email,
            'address'            => $booking->address ?? '',
            'contact_no'         => $booking->contact_no ?? 0,
        ];

        $customer = CustomerModel::getCustomerByEmail($booking->email);
        if ($customer) {
            $customer->update($attrs);
            return $customer;
        }

        return CustomerModel::create($attrs);
    }
}
