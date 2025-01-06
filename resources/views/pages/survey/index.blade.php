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
                                <h3 class="mb-0 h3_title">Demographic Survey</h3>
                            </div>
                        </div>
                    </div>
                    @include('notification.index')
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table id="tblUser" class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Group Type') }}</th>
                                        <th scope="col">{{ __('Person Type') }}</th>
                                        <th scope="col">{{ __('Address') }}</th>
                                        <th scope="col">{{ __('Religion') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($surveys->count())
                                    @foreach ($surveys as $survey)
                                    <tr>
                                        <td>{{ ucfirst($survey->group_type) }}</td>
                                        <td>{{ ucfirst($survey->person_type) }}</td>
                                        <td>{{ $survey->address }}</td>
                                        <td>{{ $survey->religion }}</td>
                                        <td>{{ $survey->created_at->format('M d, Y h:i a') }}</td>
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

</script>
@endpush
