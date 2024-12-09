@extends('layouts.app', [
'class' => '',
'elementActive' => 'announcement'
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
                                <h3 class="mb-0 h3_title">Announcement</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('announcement.index') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('notification.index')
                        <form method="post" action="{{ route('announcement.update',$announcements) }}" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('put')
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Who</label>
                                        <input type="text" name="who" class="form-control" required value="{{old('who',$announcements['who'])}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>What</label>
                                        <input type="text" name="what" class="form-control" required value="{{old('what',$announcements['what'])}}" />
                                    </div>
                                    <div class="form-group">
                                        <label>Where</label>
                                        <input type="text" name="where" class="form-control" required value="{{old('where',$announcements['where'])}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>When</label>
                                         <input type="text" class="reservationtime form-control float-right" id="when" name="when" value="{{old('when',$announcements['when'])}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea id="summernote" name="description" placeholder="Place some text here" rows="3">
                                            <?php
                                                echo html_entity_decode($announcements['description']);
                                            ?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Attachment</label>
                                        <input type="file" class="form-control" name="attachment" value="{{old('attachment',$announcements['attachment'])}}" id="image-input" onchange="previewImage(event)" />
                                    </div>
                                    <img id="image-preview" src="{{ $announcements->announcement ? asset('images/announcement/' . $announcements->announcement) : asset('images/default-announcement.png') }}" alt="Preview Image" onerror="this.src='{{ asset('images/default-announcement.png') }}';" style="width: 200px; height: auto; margin-top: 10px;"
                                />
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
   $('#summernote').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
    });

    var selectedDate = moment(new Date()).startOf('day');
    $('.reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        startDate: selectedDate,
        endDate: selectedDate,
        minDate: selectedDate,
        locale: {
            format: 'MM/DD/YYYY hh:mm A'
        },
        autoApply: true,
        drops: 'up'
    });

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
                preview.src = '{{ asset("images/default-announcement.png") }}';
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '{{ asset("images/default-announcement.png") }}';
            preview.style.display = 'block';
        }
    }
</script>
@endpush