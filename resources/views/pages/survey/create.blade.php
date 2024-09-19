@extends('layouts.app', [
'class' => '',
'elementActive' => 'survey'
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
                                <h3 class="mb-0 h3_title">Volunteer</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('volunteer.index') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('volunteer.store') }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>
                        
                                    <select name="room_type" id="room_type" class="room_type form-control">
                                        <option selected value="">Select option</option>
                                        @foreach (App\Models\BookingOvernightStayModel::ROOM_TYPE as $key => $type)
                                          <option value="{{$key}}">{{$type}}</option>
                                        @endforeach
                                      </select>
                      
                                    <div class="form-group">
                                      <label for="address">Address</label>
                                      <input type="text" class="form-control" name="address" id="address" required autofocus  placeholder="{{ __('Enter Address') }}">
                                    </div>
                      
                                    <div class="form-group">
                                      <label for="birthday">Birthday</label>
                                      <input type="date" class="form-control" name="birthday" id="birthday" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>
                      
                                    <div class="form-group">
                                      <label for="church_name">Church Name</label>
                                      <input type="text" class="form-control" name="church_name" id="church_name" required autofocus  placeholder="{{ __('Enter Church Name') }}">
                                    </div>
                      
                                    <div class="form-group">
                                      <label for="pastor_name">Pastor Name</label>
                                      <input type="text" class="form-control" name="pastor_name" id="pastor_name" required autofocus  placeholder="{{ __('Enter Name') }}">
                                    </div>
                      
                                    <div class="form-group">
                                      <label for="pastor_recommendation">Pastor Recommendation</label>
                                      <input type="text" class="form-control" name="pastor_recommendation" id="pastor_recommendation" required autofocus  placeholder="{{ __('Enter recommendation') }}">
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