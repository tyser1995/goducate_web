@extends('layouts.app', [
'class' => '',
'elementActive' => 'announcement'
])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8 user-font">
                            <h3 class="mb-0">{{ __('Announcement') }}</h3>
                        </div>
                        <div class="col-4 text-right add-user">
                            <a href="{{ route('announcement.create') }}" class="btn btn-sm btn-primary" id="add-user">{{
                                __('Add Announcement') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="tblData" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Who') }}</th>
                                    <th scope="col">{{ __('What') }}</th>
                                    <th scope="col">{{ __('Where') }}</th>
                                    <th scope="col">{{ __('When') }}</th>
                                    <th scope="col">{{ __('Attachment') }}</th>
                                    <th scope="col">{{ __('Created Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($announcement as $announcements)
                                    <tr>
                                        <td>{{$announcements->who}}</td>
                                        <td>{{$announcements->what}}</td>
                                        <td>{{$announcements->where}}</td>
                                        <td>{{$announcements->when}}</td>
                                        <td>{{$announcements->attachment}}</td>
                                        <td>{{$announcements->created_at}}</td>
                                        <td>
                                            <a href="{{ route('announcement.edit', $announcements) }}" class="{{Auth::user()->can('announcement-edit') ? 'btn btn-info btn-sm ' : 'btn btn-info btn-sm d-none'}}"><i class="fas fa-pen"></i></a>
                                        </td>
                                        
                                    </tr>
                                @endforeach
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
$(document).ready(function() {
    $('#tblData').DataTable();


    // $('#tblUser tbody').on('click','.btnCanDestroy',function() {
    //         Swal.fire({
    //             // title: 'Error!',
    //             text: 'Do you want to remove ' + $(this).val() + ' user?',
    //             icon: 'question',
    //             allowOutsideClick:false,
    //             confirmButtonText: 'Yes',
    //             showCancelButton: true,
    //         }).then((result) => {
    //             if (result.value) {
    //                 window.location.href = base_url + "/users/delete/" + $(this).data('id');
    //                 Swal.fire({
    //                     title: $(this).val() + ' Deleted Successfully',
    //                     icon: 'success',
    //                     allowOutsideClick:false,
    //                     confirmButtonText: 'Close',
    //                 }).then(()=>{
    //                     $('#tblUser').DataTable().ajax.reload();
    //                 });
    //             }
    //         });
    //     });

        // $('#tblUser tbody').on('click','.btnCanVerify',function() {
        //     Swal.fire({
        //         // title: 'Error!',
        //         text: 'Verify ' + $(this).val() + ' user?',
        //         icon: 'question',
        //         allowOutsideClick:false,
        //         confirmButtonText: 'Yes',
        //         showCancelButton: true,
        //     }).then((result) => {
        //         if (result.value) {
        //             window.location.href = base_url + "/users/verify/" + $(this).data('id');
        //             Swal.fire({
        //                 title: $(this).val() + ' Verified Successfully',
        //                 icon: 'success',
        //                 allowOutsideClick:false,
        //                 confirmButtonText: 'Close',
        //             }).then(()=>{
        //                 $('#tblUser').DataTable().ajax.reload();
        //             });
        //         }
        //     });
        // });

});
</script>
@endpush
