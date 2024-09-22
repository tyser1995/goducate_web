@extends('layouts.app', [
'class' => '',
'elementActive' => 'announcement'
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
                                <h3 class="mb-0 h3_title">Announcement</h3>
                            </div>
                            <div class="col-4 text-right add-region-btn {{$announcements->count() > 0 ? 'd-none' :''}}">
                                <a href="{{ route('announcement.create') }}" class="btn btn-sm btn-primary"
                                    id="add-region-btn">{{ __('Add Announcement') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('notification.index')
                        @foreach ($announcements as $announcement)
                            <p>Description:</p>
                            <?php
                                echo html_entity_decode($announcement['description']);
                            ?>
                            <br/>
                            @if ($announcement->attachment)
                                <img src="{{ asset('images/announcement/' . $announcement->attachment) }}" class="mb-2" style="width: 150px; height:150px" alt="{{ $announcement->attachment }}" />
                            @else
                                <span>No attachment.</span>
                            @endif
                            <br/>
                            <a href="{{ route('announcement.edit', Hashids::encode($announcement->id)) }}" class="btn btn-info btn-sm"><i class="fas fa-pen"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $announcement->id }})"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-{{ $announcement->id }}" action="{{ route('announcement.destroy', $announcement->id) }}" method="POST" style="display: none;">
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
