<?php

namespace Tests\Feature;

use App\Models\Accomodation;
use App\Models\BookingModel;
use App\Models\CustomerModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private function makeAccommodation(): Accomodation
    {
        return Accomodation::create([
            'type'        => 'Standard Room',
            'qty'         => 10,
            'capacity'    => 4,
            'amount'      => 1500.00,
            'description' => 'A standard room.',
        ]);
    }

    private function adminUser(): User
    {
        return User::factory()->create(['role' => 1]);
    }

    // -----------------------------------------------------------------------
    // Public booking store
    // -----------------------------------------------------------------------

    public function test_guest_can_submit_a_booking_with_valid_data(): void
    {
        $room = $this->makeAccommodation();

        $response = $this->postJson(route('bookings.store'), [
            'name'            => 'Juan Dela Cruz',
            'email'           => 'juan@example.com',
            'address'         => '123 Mabini St, Manila',
            'contact_no'      => '09171234567',
            'no_of_adults'    => 2,
            'no_of_children'  => 1,
            'booking_status'  => 0,
            'accomodation_id' => [$room->id],
            'checkin_date'    => now()->addDays(3)->toDateString(),
            'checkout_date'   => now()->addDays(5)->toDateString(),
        ]);

        $response->assertStatus(201)->assertJson(['success' => true]);
        $this->assertDatabaseHas('bookings', ['email' => 'juan@example.com']);
    }

    public function test_booking_fails_with_missing_required_fields(): void
    {
        $response = $this->postJson(route('bookings.store'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'checkin_date', 'checkout_date']);
    }

    public function test_booking_fails_when_checkout_is_before_checkin(): void
    {
        $room = $this->makeAccommodation();

        $response = $this->postJson(route('bookings.store'), [
            'name'            => 'Maria Santos',
            'email'           => 'maria@example.com',
            'address'         => 'Quezon City',
            'contact_no'      => '09181234567',
            'no_of_adults'    => 2,
            'no_of_children'  => 0,
            'booking_status'  => 0,
            'accomodation_id' => [$room->id],
            'checkin_date'    => now()->addDays(5)->toDateString(),
            'checkout_date'   => now()->addDays(3)->toDateString(),
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['checkout_date']);
    }

    public function test_booking_fails_when_checkin_is_in_the_past(): void
    {
        $room = $this->makeAccommodation();

        $response = $this->postJson(route('bookings.store'), [
            'name'            => 'Pedro Reyes',
            'email'           => 'pedro@example.com',
            'address'         => 'Makati City',
            'contact_no'      => '09191234567',
            'no_of_adults'    => 1,
            'no_of_children'  => 0,
            'booking_status'  => 0,
            'accomodation_id' => [$room->id],
            'checkin_date'    => now()->subDay()->toDateString(),
            'checkout_date'   => now()->addDays(2)->toDateString(),
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['checkin_date']);
    }

    public function test_booking_creates_customer_record_when_none_exists(): void
    {
        $room = $this->makeAccommodation();

        $this->postJson(route('bookings.store'), [
            'name'            => 'New Guest',
            'email'           => 'newguest@example.com',
            'address'         => 'Cebu City',
            'contact_no'      => '09201234567',
            'no_of_adults'    => 1,
            'no_of_children'  => 0,
            'booking_status'  => 0,
            'accomodation_id' => [$room->id],
            'checkin_date'    => now()->addDays(2)->toDateString(),
            'checkout_date'   => now()->addDays(4)->toDateString(),
        ]);

        $this->assertDatabaseHas('customers', ['email' => 'newguest@example.com']);
    }

    // -----------------------------------------------------------------------
    // Admin booking status update
    // -----------------------------------------------------------------------

    public function test_admin_can_update_booking_status(): void
    {
        $admin = $this->adminUser();
        $customer = CustomerModel::create([
            'created_by_user_id' => $admin->id,
            'first_name'         => 'Test',
            'middle_name'        => '',
            'last_name'          => 'Customer',
            'email'              => 'testcust@example.com',
            'address'            => 'Manila',
            'contact_no'         => '09001234567',
        ]);

        $room = $this->makeAccommodation();
        $booking = BookingModel::create([
            'created_by_user_id' => $admin->id,
            'customer_id'        => $customer->id,
            'name'               => 'Test Customer',
            'email'              => 'testcust@example.com',
            'address'            => 'Manila',
            'contact_no'         => '09001234567',
            'no_of_adults'       => 2,
            'no_of_children'     => 0,
            'booking_status'     => 0,
            'checkin_date'       => now()->addDays(3)->toDateString(),
            'checkout_date'      => now()->addDays(5)->toDateString(),
            'accomodation_id'    => $room->id,
            'accomodation_name'  => $room->type,
            'accomodation_qty'   => $room->qty,
            'accomodation_taken' => 1,
            'status'             => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->putJson(route('booking.update', $customer->id), [
                'status' => 'approved',
            ]);

        $response->assertStatus(200)->assertJson(['status' => 'success']);
    }

    // -----------------------------------------------------------------------
    // Booking deletion
    // -----------------------------------------------------------------------

    public function test_admin_can_delete_booking(): void
    {
        $admin = $this->adminUser();
        $room = $this->makeAccommodation();
        $customer = CustomerModel::create([
            'created_by_user_id' => $admin->id,
            'first_name'         => 'Delete',
            'middle_name'        => '',
            'last_name'          => 'Me',
            'email'              => 'deleteme@example.com',
            'address'            => 'Somewhere',
            'contact_no'         => '09001111111',
        ]);

        BookingModel::create([
            'created_by_user_id' => $admin->id,
            'customer_id'        => $customer->id,
            'name'               => 'Delete Me',
            'email'              => 'deleteme@example.com',
            'address'            => 'Somewhere',
            'contact_no'         => '09001111111',
            'no_of_adults'       => 1,
            'no_of_children'     => 0,
            'booking_status'     => 0,
            'checkin_date'       => now()->addDays(1)->toDateString(),
            'checkout_date'      => now()->addDays(2)->toDateString(),
            'accomodation_id'    => $room->id,
            'accomodation_name'  => $room->type,
            'accomodation_qty'   => $room->qty,
            'accomodation_taken' => 1,
            'status'             => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('booking.destroy', $customer->id));

        $response->assertRedirect(route('booking.index'));
        $this->assertSoftDeleted('bookings', ['email' => 'deleteme@example.com']);
    }
}
