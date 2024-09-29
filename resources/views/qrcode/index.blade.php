@extends('layouts.app', [
'class' => '',
'elementActive' => 'qrcode'
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
                                <h3 class="mb-0 h3_title">QR Code</h3>
                            </div>
                            @can('qrcode-create')
                                <div class="col-4 text-right add-region-btn">
                                    <button type="button" id="addQrButton" class="btn btn-lg btn-sm btn-primary" title="Generate QR" onclick="generateQrCode()">
                                        {{ __('Generate QR Code') }}
                                    </button>
                                    {{-- <a href="#!" class="btn btn-sm btn-primary"
                                        id="add-region-btn" onclick="generateQrCode()">{{ __('Generate QR Code') }}</a> --}}
                                </div>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        @include('notification.index')
                        <div class="row">
                            @foreach ($qrcodes as $qrcode)
                                <div class="col-4">
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <h3>{{$qrcode->created_at}}{{$qrcode->id}}</h3>
                                        </div>
                                        <div class="card-body" id="card-body-{{ $qrcode->id }}">
                                            {{QrCode::size(300)->generate($qrcode->qrcode_generated)}}
                                        </div>
                                        <div class="card-footer">
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="printCard({{ $qrcode->id }})" title="Print QR Code">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="openAddFundsModal({{ $qrcode->id }},{{$qrcode->amount}})" title="Add/View Funds">
                                                <i class="fas fa-money-bill"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $qrcode->id }})" title="Remove QR Code"><i class="fas fa-trash"></i></button>
                                            <form id="delete-form-{{ $qrcode->id }}" action="{{ route('qrcode.destroy',$qrcode->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <p>Recreational Remaining: {{$qrcode->amount}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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

    function generateQrCode() {
        let number = "{{now()->format('Yhis')}}"

        if (!number) {
            alert("Number is required to generate QR code!");
            return;
        }

        // Send AJAX request to the server to generate the QR code
        $.ajax({
            url: '/generate-code',  // Your route to the controller method
            type: 'POST',
            data: {
                number: number,
                _token: '{{ csrf_token() }}'  // Include CSRF token for security
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error generating QR code:', error);
            }
        });
    }
    
    function printCard(id) {
        var content = document.getElementById('card-body-' + id).innerHTML;

        var printWindow = window.open('', '', 'height=400,width=400');
        printWindow.document.write('<html><head><title>Print QR Code</title>');
        printWindow.document.write('<style>body { font-family: Arial, sans-serif; }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        printWindow.onload = function() {
            printWindow.focus();
            printWindow.print(); 
            //printWindow.close();
        };
    }

    function openAddFundsModal(id,amount) {
        Swal.fire({
            title: 'QR Funds',
            html: `<label>Balance:</label>
                <input type="number" disabled value="${amount}" class="swal2-input" placeholder="Enter amount"><br/>
                <label>Amount:</label>
                <input type="number" id="fundsAmount" class="swal2-input" placeholder="Enter amount">
                <input type="hidden" id="qrcodeId" value="${id}">
            `,
            confirmButtonText: 'Submit',
            showCancelButton: true,
            preConfirm: () => {
                const fundsAmount = Swal.getPopup().querySelector('#fundsAmount').value;
                const qrcodeId = Swal.getPopup().querySelector('#qrcodeId').value;
                if (!fundsAmount || fundsAmount <= 0) {
                    Swal.showValidationMessage('Please enter a valid amount');
                    return false;
                }
                return { fundsAmount, qrcodeId };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                updateFunds(result.value.qrcodeId, result.value.fundsAmount);
            }
        });
    }

    // Function to send AJAX request to update the funds
    function updateFunds(qrcodeId, fundsAmount) {
        $.ajax({
            url: "{{ route('funds.update') }}", 
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: qrcodeId,
                funds: fundsAmount
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Funds updated successfully!',
                    text: response.message
                });
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Please try again later.'
                });
            }
        });
    }
</script>
@endpush
