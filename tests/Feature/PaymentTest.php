<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::factory()->create(['role' => 1]);
    }

    private function customer(User $admin): CustomerModel
    {
        return CustomerModel::create([
            'created_by_user_id' => $admin->id,
            'first_name'         => 'Pay',
            'middle_name'        => '',
            'last_name'          => 'Test',
            'email'              => 'paytest@example.com',
            'address'            => 'Manila',
            'contact_no'         => '09001234567',
        ]);
    }

    // -----------------------------------------------------------------------
    // Payment creation
    // -----------------------------------------------------------------------

    public function test_admin_can_add_payment_for_customer(): void
    {
        Storage::fake('local');
        $admin    = $this->adminUser();
        $customer = $this->customer($admin);

        $file = UploadedFile::fake()->create('receipt.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)
            ->post(route('customer.payment.store'), [
                'customer_id' => $customer->id,
                'amount'      => 1500.00,
                'attachment'  => $file,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', ['customer_id' => $customer->id]);
    }

    public function test_payment_store_rejects_missing_amount(): void
    {
        $admin    = $this->adminUser();
        $customer = $this->customer($admin);

        $response = $this->actingAs($admin)
            ->postJson(route('customer.payment.store'), [
                'customer_id' => $customer->id,
                // amount missing
            ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['amount']);
    }

    public function test_payment_store_rejects_invalid_customer_id(): void
    {
        $admin = $this->adminUser();

        $response = $this->actingAs($admin)
            ->postJson(route('customer.payment.store'), [
                'customer_id' => 99999, // does not exist
                'amount'      => 500,
            ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['customer_id']);
    }

    public function test_payment_store_rejects_disallowed_file_type(): void
    {
        $admin    = $this->adminUser();
        $customer = $this->customer($admin);

        $file = UploadedFile::fake()->create('malware.exe', 100, 'application/octet-stream');

        $response = $this->actingAs($admin)
            ->postJson(route('customer.payment.store'), [
                'customer_id' => $customer->id,
                'amount'      => 500,
                'attachment'  => $file,
            ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['attachment']);
    }

    public function test_payment_store_rejects_oversized_file(): void
    {
        $admin    = $this->adminUser();
        $customer = $this->customer($admin);

        $file = UploadedFile::fake()->create('big.pdf', 6000, 'application/pdf'); // 6 MB > 5 MB limit

        $response = $this->actingAs($admin)
            ->postJson(route('customer.payment.store'), [
                'customer_id' => $customer->id,
                'amount'      => 500,
                'attachment'  => $file,
            ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['attachment']);
    }

    // -----------------------------------------------------------------------
    // Payment visibility (viewing marks as seen)
    // -----------------------------------------------------------------------

    public function test_viewing_customer_payments_marks_them_as_viewed(): void
    {
        $admin    = $this->adminUser();
        $customer = $this->customer($admin);

        Payment::create([
            'created_by_user_id' => $admin->id,
            'customer_id'        => $customer->id,
            'amount'             => 500,
            'attachment'         => null,
            'payment_status'     => 'Partial',
        ]);

        $this->actingAs($admin)
            ->get(route('customer.payment', Hashids::encode($customer->id)));

        $this->assertDatabaseMissing('payments', [
            'customer_id'    => $customer->id,
            'payment_status' => 'Partial',
        ]);
    }

    // -----------------------------------------------------------------------
    // Unauthenticated access
    // -----------------------------------------------------------------------

    public function test_unauthenticated_user_cannot_add_payment(): void
    {
        $response = $this->postJson(route('customer.payment.store'), [
            'customer_id' => 1,
            'amount'      => 500,
        ]);

        $response->assertStatus(401);
    }
}
