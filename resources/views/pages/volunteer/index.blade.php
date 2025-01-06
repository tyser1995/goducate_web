@extends('layouts.app', [
'class' => '',
'elementActive' => 'volunteer'
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
                            @if (Auth::user()->can('volunteer-create'))
                                <div class="col-4 text-right add-region-btn">
                                    <a href="{{ route('volunteer.create') }}" class="btn btn-sm btn-primary"
                                        id="add-region-btn">{{ __('Add Volunteer') }}</a>
                                </div>
                            @endif
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
                                        <td class="text-right" style="display: flex;
                                        align-items: center;">

                                            @if (Auth::user()->can('volunteer-edit'))
                                                @if (strtoupper($volunteer->status) == "APPROVED")
                                                    <a style="pointer-events: none" class="btn-success btn-sm" title="Approved"><i class="fas fa-check-circle"></i></a>
                                                @else
                                                    <button type="button" data-id="{{$volunteer->id}}"
                                                    value="{{$volunteer->name}}"
                                                    class="btnCanVerify btn-warning btn-sm" title="Click to approve"><i
                                                        class="fas fa-exclamation-triangle"></i></button>
                                                    </button>
                                                @endif

                                                <a href="{{ route('volunteer.edit', $volunteer) }}" class="btn btn-info btn-sm"><i class="fas fa-pen"></i></a>
                                            @endif
                                            @if (Auth::user()->can('volunteer-delete'))
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $volunteer->id }})"><i class="fas fa-trash"></i></button>
                                                <form id="delete-form-{{ $volunteer->id }}" action="{{ route('volunteer.destroy', $volunteer->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                            
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
    $('#tblUser').DataTable();
    
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

    $('#tblUser tbody').on('click', '.btnCanVerify', function () {
        let userId = $(this).data('id');
        let userName = $(this).val();

        Swal.fire({
            text: `Approve ${userName} user?`,
            icon: 'question',
            allowOutsideClick: false,
            confirmButtonText: 'Yes',
            showCancelButton: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `${base_url}/volunteers.verify/${userId}`,
                    type: 'GET',
                    success: function (response) {
                        Swal.fire({
                            title: `${userName} Approved Successfully`,
                            icon: 'success',
                            allowOutsideClick: false,
                            confirmButtonText: 'Close',
                        }).then(() => {
                            $('#tblUser').DataTable().ajax.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            allowOutsideClick: false,
                            confirmButtonText: 'Close',
                        });
                    }
                });
            }
        });
    });

</script>
@endpush
