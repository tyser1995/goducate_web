@extends('layouts.app', [
'class' => '',
'elementActive' => 'feedback_form'
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
                                <h3 class="mb-0 h3_title">Feedback</h3>
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
                                    <th>Services</th>
                                    <th>Ratings</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($feedbacks))
                                    @foreach ($feedbacks as $feedback)
                                    <tr>
                                        <td class="d-none">{{ $feedback->id ?? '' }}</td>
                                        <td>{{ ucfirst($feedback->services) }}</td>
                                        <td>{{ ucfirst($feedback->ratings) }} - ({{ $feedback->rating_count }})</td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr style="text-align: center; font-size: large; vertical-align: middle;">
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
