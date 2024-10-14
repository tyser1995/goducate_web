@extends('layouts.app', [
'class' => '',
'elementActive' => 'customer'
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
                                <h3 class="mb-0 h3_title">Customer</h3>
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
                                <input type="hidden" name="customer_id" value="{{ $customers->id }}" class="form-control form-control-alternative">
                            
                                <!-- Customer Information -->
                                <div class="row form-group">
                                    <div class="col-6">
                                        <label for="name">Name</label>
                                        <p>{{ $customers->first_name . ' ' . $customers->last_name }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="name">Email</label>
                                        <input type="hidden" name="email" value="{{$customers->email}}" />
                                        <p>{{ $customers->email }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="name">Address</label>
                                        <p>{{ $customers->address }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label for="name">Contact</label>
                                        <p>{{ $customers->contact_no }}</p>
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
                                            $totalAmount = 0;
                                        @endphp
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->description }}</td>
                                                <td>{{ $transaction->amount }}</td>
                                            </tr>
                                            @php
                                                $totalAmount += $transaction->amount;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Total Payments</strong></td>
                                            <td><strong>{{ $totalAmount }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div id="billing-summary" class="billing-summary d-none">
                                    <h2>Goducate Resort Daily Report</h2>
                                    <p>Date: {{ now()->format('M d, Y') }}</p>
                            
                                    <h3>Billing Summary:</h3>
                                    @foreach ($transactions as $transaction)
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                {{ $transaction->description }}
                                            </div>
                                            <div class="col-3">
                                                {{ $transaction->amount }}
                                            </div>
                                        </div>
                                    @endforeach
                            
                                    <p><strong>Total Payments:</strong> {{ $totalAmount }}</p>
                            
                                    <p>Prepared by:</p>
                                    <p>{{ Auth::user()->name }}</p>
                                    <p>Staff</p>
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
    function printBillingSummary() {
        var printContents = document.getElementById('billing-summary').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
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
</script>
@endpush