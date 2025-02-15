@extends('layouts.app', [
'class' => '',
'elementActive' => 'customer'
])

@section('content')
<style>
    .billing-summary {
        font-family: 'Arial', sans-serif; /* Change to a suitable font */
        padding: 20px;
        max-width: 600px; /* Limit the width of the receipt */
        margin: auto; /* Center the receipt */
        border: 1px solid #ccc; /* Light border for the receipt */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        background-color: #fff; /* White background */
    }

    .receipt-header {
        text-align: center; /* Center the header */
        margin-bottom: 20px;
    }

    h2 {
        margin: 0; /* Remove default margin */
        font-size: 24px; /* Increase font size for the header */
    }

    h3 {
        margin-top: 20px;
        font-size: 20px; /* Slightly smaller for sub-header */
        border-bottom: 2px solid #000; /* Underline for the section */
        padding-bottom: 5px; /* Spacing under the underline */
    }

    .billing-details {
        margin-bottom: 20px; /* Space between billing details and total */
    }

    .row {
        display: flex; /* Use flexbox for the row */
        justify-content: space-between; /* Space out items */
        align-items: center; /* Center align vertically */
    }

    .total-summary {
        font-weight: bold; /* Make total summary bold */
        font-size: 18px; /* Slightly larger font for total */
        border-top: 2px solid #000; /* Underline for total */
        padding-top: 10px; /* Space above total */
        margin-top: 20px; /* Space above total section */
    }

    .prepared-by {
        text-align: right; /* Align to the right */
        margin-top: 20px; /* Space above prepared by section */
    }
</style>
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card  shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 h3_title" style="border-bottom:0">Customer</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('customer.index') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('notification.index')
                        <form method="post" action="{{ route('customer.payment.store') }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{ Auth::user()->id }}" class="form-control form-control-alternative">
                                <input type="hidden" name="customer_id" value="{{ $customers->id }}" class="form-control form-control-alternative" id="customer_id">
                            
                                <!-- Customer Information -->
                                <div class="form-group row">
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="col-2">
                                                <p for="name">Name:</p>
                                           </div>
                                           <div class="col-4">
                                                <p for="name">{{old('name',$customers->first_name . ' ' . $customers->last_name)}}</p>
                                            </div>
                                            <div class="col-2">
                                                <p for="email">Email:</p>
                                           </div>
                                           <div class="col-4">
                                                <p for="email">{{old('email',$customers->email)}}</p>
                                                <input type="hidden" name="email" value="{{old('email',$customers->email)}}" />
                                            </div>
                                            <div class="col-2">
                                                <p for="address">Address:</p>
                                           </div>
                                           <div class="col-4">
                                                <p for="address">{{old('address',$customers->address)}}</p>
                                            </div>
                                            <div class="col-2">
                                                <p for="contact_no">Contact No.:</p>
                                           </div>
                                           <div class="col-4">
                                            <p>{{ $customers->contact_no }}</p>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="name">Partial Payment</label>
                                                <?php
                                                    $payment_img = App\Models\Payment::getPaymentByCustomerIdOnly($customers->id);
                                                ?>
                                                @if($payment_img && $payment_img->attachment)
                                                    <a href="javascript:void(0)" onclick="showPaymentImageModal('{{ asset('images/payment/' . ($payment_img->attachment ?? '')) }}')">View</a>
                                                @else
                                                    @if ($payment_img)
                                                        <p>Walk-in payment: {{$payment_img->amount}}</p>
                                                    @else
                                                        <p>No payment image available</p>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Transaction Input -->
                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <select name="description" id="description" class="form-control" required>
                                        <option selected value="">Select option</option>
                                        @foreach (App\Models\Transaction::DESCRIPTION as $key => $type)
                                            <option value="{{ $key }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group others_container d-none">
                                    <label for="name">Others</label>
                                    <input type="text" min="1" class="form-control" name="others" id="others" required disabled autofocus placeholder="{{ __('Enter query') }}">
                                </div>
                            
                                <div class="form-group">
                                    <label for="name">Amount</label>
                                    <input type="number" min="1" class="form-control" name="amount" id="amount" required autofocus placeholder="{{ __('Enter Amount') }}">
                                </div>
                            
                                <div class="">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <button type="button" class="btn btn-default mt-4" onclick="printBillingSummary()"><i class="fas fa-print"></i></button>
                                </div>
                                <hr />
                            
                                <!-- Billing Summary Table -->
                                <table id="tblEmployeeData" class="table table-responsive-sm table-flush display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Group transactions by description and sum the amounts
                                            $groupedTransactions = $transactions->groupBy('description')->map(function ($group) {
                                                return [
                                                    'description' => $group->first()->description,
                                                    'count' => $group->count(), // Count of occurrences
                                                    'totalAmount' => $group->sum('amount'),
                                                ];
                                            });
                                            $totalOverallAmount = $groupedTransactions->sum('totalAmount'); // Total for all descriptions
                                        @endphp
                                
                                        @if($groupedTransactions->isEmpty())
                                            <tr>
                                                <td colspan="2" class="text-center">No transactions found.</td>
                                            </tr>
                                        @else
                                            @foreach ($groupedTransactions as $transaction)
                                                <tr>
                                                    <td>
                                                        {{ $transaction['description'] }}
                                                        @if($transaction['count'] > 1)
                                                            ({{ $transaction['count'] }}) <!-- Or use " {{ $transaction['count'] }}x" for 2x format -->
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($transaction['totalAmount'], 2) }}</td> <!-- Format the total amount -->
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Total Payments</strong></td>
                                            <td><strong>{{ number_format($totalOverallAmount, 2) }}</strong></td> <!-- Format the overall total -->
                                        </tr>
                                    </tfoot>
                                </table>
                                
                                
                                

                                <div id="billing-summary" class="billing-summary d-none">
                                    <div class="receipt-header">
                                        <h2>Goducate Resort Daily Report</h2>
                                        <p>Date: {{ now()->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <h3>Billing Summary:</h3>
                                    <div class="billing-details">
                                        @foreach ($transactions as $transaction)
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    {{ $transaction->description }}
                                                </div>
                                                <div class="col-6 text-right">
                                                    {{ number_format($transaction->amount, 2) }} <!-- Format the amount -->
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                
                                    <div class="total-summary">
                                        <p><strong>Total Payments:</strong> {{ number_format($totalOverallAmount, 2) }}</p>
                                    </div>
                                
                                    <div class="prepared-by">
                                        <p>Prepared by:</p>
                                        <p><strong>{{ Auth::user()->name }}</strong></p>
                                        <p>Staff</p>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Image -->
<div class="modal fade" id="paymentImageModal" tabindex="-1" role="dialog" aria-labelledby="paymentImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentImageModalLabel">Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="paymentImage" src="" alt="Payment Image" style="width: 100%; height: auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@include('employees.script')
@push('scripts')
<script>
    function printBillingSummary() {
        var printContents = document.getElementById('billing-summary').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        $.ajax({
            url: "{{ route('transaction.delete') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                customer_id: $('#customer_id').val()
            },
            success: function(response) {
                if (response.success) {
                    console.log(`Deleted ${response.deleted_count} transactions successfully.`);
                    //printBillingSummary();
                } else {
                    console.log('Failed to delete transactions.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                console.log('An error occurred while deleting transactions.');
            }
        });


    }

    $('#description').change(function (e) {
        if($(this).val() == "others"){
            $('.others_container').removeClass('d-none');
            $('#others').removeAttr('disabled');
            $('#others').attr('required');
        }else{
            $('.others_container').addClass('d-none');
            $('#others').attr('disabled','disabled');
            $('#others').removeAttr('required');
        }
    });

    function showPaymentImageModal(imageSrc) {
        // Set the image source for the modal
        document.getElementById('paymentImage').src = imageSrc;
        
        // Show the modal
        $('#paymentImageModal').modal('show');
    }
</script>
@endpush