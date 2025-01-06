@extends('layouts.app', [
'class' => '',
'elementActive' => 'report'
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
                                <h3 class="mb-0 h3_title">QR Logs</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('notification.index')
                        <table id="tblDataTable" class="table table-responsive-sm table-flush display"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Description</th>
                                    <th>Usage</th>
                                    {{-- <th>Created date</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if ($reports->count())
                                    @foreach ($reports as $report)
                                    <tr>
                                        <td class="d-none">{{ $report->id }}</td>
                                        <td>{{ $report->description}}</td>
                                        <td>{{ $report->count}}</td>
                                        {{-- <td>{{ $report->created_at}}</td> --}}
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
