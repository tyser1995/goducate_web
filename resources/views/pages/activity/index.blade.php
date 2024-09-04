@extends('layouts.app', [
'class' => '',
'elementActive' => 'activities'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        {{-- Header --}}
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    @include('notification.index')
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 h3_title">Activity Header</h3>
                            </div>
                            <div class="col-4 text-right add-region-btn {{$headers->count() > 0 ? 'd-none' :''}}">
                                <a href="{{ route('activity.create') }}" class="btn btn-sm btn-primary"
                                    id="add-region-btn">{{ __('Add Activity Header') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @foreach ($headers as $header)
                            <?php
                                echo html_entity_decode($header['description']);
                            ?>
                            <a href="{{ route('activity.edit', $header->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pen"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $header->id }})"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-{{ $header->id }}" action="{{ route('activity.destroy', $header->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- List --}}
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 h3_title">Activity List</h3>
                            </div>
                            <div class="col-4 text-right add-region-btn">
                                <a href="{{ route('activities/create/list') }}" class="btn btn-sm btn-primary"
                                    id="add-region-btn">{{ __('Add Activity List') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($lists as $list)
                <div class="col-3">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="mb-0">{{$list->title}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('images/header_list/' . $list->image) }}" class="mb-2" style="width: 100%; height:300px" alt="{{ $list->title }}" />
                            <a href="{{ route('activities.edit.list', ['id' => $list->id]) }}" class="btn btn-info btn-sm" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $list->id }})"><i class="fas fa-trash"></i></button>
                            <!-- Delete Form -->
                            <form id="delete-form-{{ $list->id }}" action="{{ route('activities.delete.list', ['id' => $list->id]) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
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
