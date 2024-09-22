@extends('layouts.app', [
'class' => '',
'elementActive' => 'customer'
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
                                <h3 class="mb-0 h3_title">Customer</h3>
                            </div>
                            @can('customer-create')
                                <div class="col-4 text-right add-region-btn">
                                    <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary"
                                        id="add-region-btn">{{ __('Add Customer') }}</a>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Created date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($customers->count())
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td class="d-none">{{ $customer->id ?? $customer->users_id}}</td>
                                        @if ($customer->first_name)
                                            <td>{{$customer->first_name . ' '. $customer->last_name}}</td>
                                        @else
                                            <td>{{$customer->name }}</td>
                                        @endif
                                        
                                        <td>
                                            <a href="mailto:{{ $customer->email ?? $customer->users_email }}">{{ $customer->email ?? $customer->users_email}}</a>
                                        </td>
                                        <td>{{ $customer->address}}</td>
                                        <td>{{ $customer->contact_no}}</td>
                                        <td>{{ $customer->created_at->format('M d, Y h:i a') }}</td>
                                        <td class="text-right" style="display: flex;
                                        align-items: center;">
                                            {{-- <button type="button" data-id="{{Hashids::encode($customer->id)}}"
                                            value="{{$customer->name}}"
                                            class="btnGenerateQR btn btn-default btn-sm" ><i
                                                class="fas fa-qrcode"></i>
                                            </button> --}}
                                            <a href="{{ route('customer.generate_qrcode', Hashids::encode($customer->id)) }}" class="btn btn-default btn-sm mr-1"><i class="fas fa-qrcode"></i></a>
                                            @if (Auth::user()->can('customer-edit'))
                                                <a href="{{ route('customer.edit', Hashids::encode($customer->id)) }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-pen"></i></a>
                                            @endif
                                            @if (Auth::user()->can('customer-delete'))
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $customer->id }})"><i class="fas fa-trash"></i></button>
                                                <form id="delete-form-{{ $customer->id }}" action="{{ route('customer.destroy', $customer->id) }}" method="POST" style="display: none;">
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
<script>
    // $('.btnGenerateQR').click(function(){
    //     let $id = $(this).data('id');
    //     $.ajax({
    //         url: `/customer.generate_qrcode/${$id}`,
    //         method: 'GET',
    //         headers: {
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //         },
    //         success: function(response) {
    //             if (response.success) {
    //                 // If successful, display the QR code inside the SweetAlert modal
    //                 Swal.fire({
    //                     title: 'Your QR Code',
    //                     // html: `<img src="data:image/png;base64,${response.qr_code}" alt="QR Code" style="max-width: 100%; height: auto;" />`,
    //                     html: `<div style="max-width: 100%; height: auto;">${response.qr_code}</div>`,
    //                     showCancelButton: true,
    //                     confirmButtonText: 'Download QR Code',
    //                     cancelButtonText: 'Close',
    //                     confirmButtonColor: '#3085d6',
    //                     cancelButtonColor: '#d33'
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         // If the user clicks "Download", trigger the download of the QR code
    //                         const link = document.createElement('a');
    //                         link.href = `data:image/png;base64,${response.qr_code}`;
    //                         link.download = `qrcode_${id}.png`;  // Set the filename
    //                         link.click();  // Programmatically click the link to start the download
    //                     }
    //                 });
    //             } else {
    //                 // Handle failure to generate the QR code
    //                 Swal.fire('Error', 'Unable to generate QR code.', 'error');
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             // Handle any AJAX errors
    //             Swal.fire('Error', 'An unexpected error occurred.', 'error');
    //             console.error('AJAX Error:', error);
    //         }
    //     });
    // });
    
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
    
    $(document).ready(function () {
        $('#tblEmployeeData').DataTable({
            deferRender: true,
            processing: true,
            order: [[2, 'asc']],
        });
        
    });
</script>
@endpush
