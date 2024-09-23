@extends('layouts.app', [
'class' => '',
'elementActive' => 'customer'
])
@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                      <div style="max-width: 100%; height: auto;">
                        {!! $qrCode !!}
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush

