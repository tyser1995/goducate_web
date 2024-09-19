@extends('layouts.app', [
'class' => '',
'elementActive' => 'survey'
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
                                <h3 class="mb-0 h3_title">Volunteer</h3>
                            </div>
                            <div class="col-4 text-right add-region-btn">
                                <a href="{{ route('volunteer.create') }}" class="btn btn-sm btn-primary"
                                    id="add-region-btn">{{ __('Add Volunteer') }}</a>
                            </div>
                        </div>
                    </div>
                    @include('notification.index')
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table id="tblUser" class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Email') }}</th>
                                        <th scope="col">{{ __('Address') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($volunteers->count())
                                    @foreach ($volunteers as $volunteer)
                                    <tr>
                                        <td>{{ $volunteer->name }}</td>
                                        <td>
                                            <a href="mailto:{{ $volunteer->email }}">{{ $volunteer->email }}
                                            </a>
                                        </td>
                                        <td>{{ $volunteer->address }}</td>
                                        <td>{{ $volunteer->created_at->format('M d, Y h:i a') }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('volunteer.edit', $volunteer) }}" class="{{Auth::user()->can('volunteer-edit') ? 'btn btn-info btn-sm ' : 'btn btn-info btn-sm d-none'}}"><i class="fas fa-pen"></i></a>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $volunteer->id }})"><i class="fas fa-trash"></i></button>
                                            <form id="delete-form-{{ $volunteer->id }}" action="{{ route('volunteer.destroy', $volunteer->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr style=" text-align: center;font-size: large;vertical-align: middle;">
                                        <td colspan="6">{{ __('No Records found.') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
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
