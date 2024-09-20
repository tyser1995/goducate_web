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
                        <form method="post" action="{{ route('customer.store') }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                    <div class="form-group">
                                        <label for="name">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" id="middle_name" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>
                        
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" required autofocus  placeholder="{{ __('Enter Email') }}">
                                    </div>
                      
                                    <div class="form-group">
                                      <label for="address">Address</label>
                                      <input type="text" class="form-control" name="address" id="address" required autofocus  placeholder="{{ __('Enter Address') }}">
                                    </div>
                      
                                    <div class="form-group">
                                      <label for="birthday">Contact No</label>
                                      <input type="text" class="form-control" name="contact_no" id="contact_no" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="birthday">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="birthday">Re-type Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>
                                <div class="">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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