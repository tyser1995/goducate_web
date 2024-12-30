@extends('layouts.app', [
'class' => '',
'elementActive' => 'accomodation'
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
                                <h3 class="mb-0 h3_title">Accomodation</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('accomodation.index') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    @include('notification.index')
                    <div class="card-body">
                        <form method="post" action="{{ route('accomodation.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                    <div class="form-group">
                                        <label for="name">Booking Status</label>
                                        <select name="bookig_status" id="booking_status" class="form-control" required>
                                            <option disabled selected value="">Select option</option>
                                            @foreach (App\Models\Accomodation::BOOKING_STATUS as $key => $type)
                                              <option value="{{$key}}">{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group tour_type_container d-none">
                                        <label for="children">Tour Type:</label>
                                        <select name="tour_type" id="tour_type" class="room_type form-control">
                                            <option disabled selected value="">Select option</option>
                                            @foreach (App\Models\BookingDayTourModel::TOUR_TYPE as $key => $type)
                                            <option value="{{$key}}">{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Type</label>
                                        <input type="text" class="form-control" name="type" id="type" required autofocus  placeholder="{{ __('Enter Type') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Quantity</label>
                                        <input type="number" class="form-control" name="qty" id="qty" required autofocus  placeholder="{{ __('Enter number of units') }}" min="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Capacity</label>
                                        <input type="number" class="form-control" name="capacity" id="capacity" required autofocus  placeholder="{{ __('Enter Capacity') }}" min="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" name="description" id="description" required autofocus  placeholder="{{ __('Enter Description') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Amount</label>
                                        <input type="number" class="form-control" name="amount" id="amount" required autofocus  placeholder="{{ __('Enter Amount') }}" min="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" name="image" id="image-input" onchange="previewImage(event)" />
                                    </div>
                                    <img id="image-preview" src="{{asset("images/default-image.png")}}" alt="Preview Image" onerror="this.src='default-image.png';" style="width: 200px; height: auto; margin-top: 10px;" />
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
   function previewImage(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.onerror = function() {
                preview.src = '{{asset("images/default-image.png")}}';
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '{{asset("images/default-image.png")}}';
            preview.style.display = 'block';
        }
    }

    $('#booking_status').change(function (e) { 
        if($(this).val() == "0"){
            $('.tour_type_container').addClass('d-none');
            $('#tour_type').removeAttr('required');
        }else{
            $('#tour_type').attr('required','required');
            $('.tour_type_container').removeClass('d-none');
        }
    });
</script>
@endpush