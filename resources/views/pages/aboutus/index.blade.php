@extends('layouts.app', [
'class' => '',
'elementActive' => 'aboutus'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 h3_title">About Us</h3>
                            </div>
                            <div class="col-4 text-right add-region-btn {{$aboutus->count() > 0 ? 'd-none' :''}}">
                                <a href="{{ route('about.create') }}" class="btn btn-sm btn-primary"
                                    id="add-region-btn">{{ __('Add About Us') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('notification.index')
                        @foreach ($aboutus as $about)
                            <?php
                                echo html_entity_decode($about['description']);
                            ?>
                            <a href="{{ route('about.edit', $about->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pen"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $about->id }})"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-{{ $about->id }}" action="{{ route('about.destroy', $about->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
