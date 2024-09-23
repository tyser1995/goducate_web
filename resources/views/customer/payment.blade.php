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
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                    <div class="row form-group">
                                        <div class="col-6">
                                            <label for="name">Name</label>
                                            <p>{{$customers->first_name.' '.$customers->last_name}}</p>
                                        </div>
                                        <div class="col-6">
                                            <label for="name">Email</label>
                                            <p>{{$customers->email}}</p>
                                        </div>
                                        <div class="col-6">
                                            <label for="name">Address</label>
                                            <p>{{$customers->address}}</p>
                                        </div>
                                        <div class="col-6">
                                            <label for="name">Contact</label>
                                            <p>{{$customers->contact_no}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Amount</label>
                                        <input type="number" min="10" class="form-control" name="amount" id="amount" required autofocus  placeholder="{{ __('Enter Amount') }}">
                                    </div>
                                    <div class="">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                    <hr/>
                                    <table id="tblEmployeeData" class="table table-responsive-sm table-flush display"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="d-none">ID</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Created date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
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