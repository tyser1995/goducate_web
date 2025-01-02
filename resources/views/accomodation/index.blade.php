@extends('layouts.app', [
'class' => '',
'elementActive' => 'accomodation'
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
                                <h3 class="mb-0 h3_title">Accomodation</h3>
                            </div>
                            @can('accomodation-create')
                                <div class="col-4 text-right add-region-btn">
                                    <a href="{{ route('accomodation.create') }}" class="btn btn-sm btn-primary"
                                        id="add-region-btn">{{ __('Add Accomodation') }}</a>
                                </div>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        @include('notification.index')
                        <table id="tblDataTable" class="table table-responsive-sm table-flush display"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Booking Status</th>
                                    <th>Type</th>
                                    <th>Qty</th>
                                    <th>Capacity</th>
                                    <th>Price</th>
                                    <th>Created date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($accomodations->count())
                                    @foreach ($accomodations as $accomodation)
                                    <tr>
                                        <td class="d-none">{{ $accomodation->id }}</td>
                                        <td>{{ $accomodation->bookig_status == 0 ? 'Overnight Stay' : ($accomodation->bookig_status == 1 ? 'Day Tour' : 'Place Reservation') }}</td>
                                        <td>{{ $accomodation->type}}</td>
                                        <td>{{ $accomodation->qty}}</td>
                                        <td>{{ $accomodation->capacity}}</td>
                                        <td>{{ $accomodation->amount}}</td>
                                        <td>{{ $accomodation->created_at->format('M d, Y h:i a') }}</td>
                                        <td class="text-right" style="display: flex;
                                        align-items: center;">
                                            @if (Auth::user()->can('accomodation-edit'))
                                                <a href="{{ route('accomodation.edit', Hashids::encode($accomodation->id)) }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-pen"></i></a>
                                            @endif
                                            @if (Auth::user()->can('accomodation-delete'))
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $accomodation->id }})"><i class="fas fa-trash"></i></button>
                                                <form id="delete-form-{{ $accomodation->id }}" action="{{ route('accomodation.destroy', $accomodation->id) }}" method="POST" style="display: none;">
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
@endsection

@push('scripts')
@include('scripts.index');
<script>
    $('#tblDataTable').DataTable();
</script>
@endpush
