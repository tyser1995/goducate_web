@extends('layouts.app', [
'class' => '',
'elementActive' => 'activities'
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
                                <h3 class="mb-0 h3_title">Activity List</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('activities') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('notification.index')
                        <form method="post" action="{{ route('activities/store/list') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">{{ __('Title') }}</label>
                                        <input type="text" name="title"
                                            class="form-control" required
                                            autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">{{ __('Attachment') }}</label>
                                        <input type="file" name="image" required
                                            class="form-control"
                                            autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Details') }}</label>
                                        <textarea id="summernote" name="summernote" placeholder="Place some text here" rows="3" required>
                                           
                                        </textarea>
                                    </div>
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
</script>
@endpush