@extends('layouts.app', [
'class' => '',
'elementActive' => 'qrcode'
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
                                <h3 class="mb-0 h3_title">QR Code Generator</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('qrcode.index') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('notification.index')
                        <form method="post" action="{{ route('qrcode.store') }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                    <div class="form-group">
                                        <label for="name">QR Code Number</label>
                                        <input type="text" class="form-control" name="number" id="number" value="{{now()->format('Yhis')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Amount</label>
                                        <input type="number" class="form-control" name="amount" id="amount" required autofocus  placeholder="{{ __('Enter Amount') }}">
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