@extends('layouts.app', [
'class' => '',
'elementActive' => 'employees'
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
                                <h3 class="mb-0 h3_title">Employee</h3>
                            </div>
                            @can('deparment_name-create')
                                <div class="col-4 text-right add-region-btn">
                                    <a href="{{ route('employee.create') }}" class="btn btn-sm btn-primary"
                                        id="add-region-btn">{{ __('Add Employee') }}</a>
                                </div>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        @include('notification.index')
                        <table id="tblEmployeeData" class="table table-responsive-sm table-flush display"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>ID Number</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                    <th>Created date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                               
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
<script>
    $(document).ready(function () {
        $('#tblEmployeeData').DataTable({
            deferRender: true,
            processing: true,
            order: [[2, 'asc']],
        });
        $('.btnCanDestroy').click(function() {
            Swal.fire({
                // title: 'Error!',
                text: 'Do you want to remove ' + $(this).val() + ' employee?',
                icon: 'question',
                allowOutsideClick:false,
                confirmButtonText: 'Yes',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    window.location.href = base_url + "/employees/delete/" + $(this).data('id');
                    Swal.fire({
                        title: $(this).val() +' Deleted Successfully',
                        icon: 'success',
                        allowOutsideClick:false,
                        confirmButtonText: 'Close',
                    }).then(()=>{
                        $('#tblEmployeeData').DataTable().ajax.reload();
                    });
                }
            });
        });
    });
</script>
@endpush
