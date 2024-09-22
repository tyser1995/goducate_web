@extends('layouts.app', [
'class' => '',
'elementActive' => 'booknow'
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
                                <h3 class="mb-0 h3_title">Booked</h3>
                            </div>
                            <div class="col-4 text-right add-region-btn d-none">
                                <a href="{{ route('booking.create') }}" class="btn btn-sm btn-primary"
                                    id="add-region-btn">{{ __('Add Booking') }}</a>
                            </div>
                        </div>
                    </div>
                    @include('notification.index')
                    <div class="card-body">
                        <div class="table table-responsive-sm">
                            <table id="tblUser" class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th  class="d-none" scope="col">{{ __('#') }}</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Email') }}</th>
                                        <th scope="col">{{ __('Address') }}</th>
                                        <th scope="col">{{ __('Contact no') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                        <th scope="col">{{ __('Booking Status') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bookings->count())
                                    @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="d-none">{{ $booking->id }}</td>
                                        <td>{{ $booking->name }}</td>
                                        <td>
                                            <a href="mailto:{{ $booking->email }}">{{ $booking->email }}
                                            </a>
                                        </td>
                                        <td>{{ $booking->address }}</td>
                                        <td>{{ $booking->contact_no }}</td>
                                        <td>{{ $booking->created_at->format('M d, Y h:i a') }}</td>
                                        <td> 
                                            @if ($booking->status == "cancel")
                                                <span class="badge badge-danger">
                                                    Cancel booking
                                                </span>
                                            @elseif ($booking->status == "booked")
                                                <span class="badge badge-info">
                                                    Booked
                                                </span>
                                            @else
                                                <span class="badge badge-success">
                                                    Approved
                                                </span>
                                            @endif
                                        </td>
                                        <td style="display: flex;
                                        align-items: center;">
                                            @if ($booking->status == "booked")
                                                <a href="{{ route('booking.edit', Hashids::encode($booking->id)) }}" class="mr-2 btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $booking->id }})"><i class="fas fa-trash"></i></button>
                                            <form id="delete-form-{{ $booking->id }}" action="{{ route('booking.destroy', $booking->id) }}" method="POST" style="display: none;">
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
