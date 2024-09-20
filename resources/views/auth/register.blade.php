@extends('layouts.app-auth', [
'class' => 'main-page'
])
@section('content')
<div class="card login-form">
    <div>
        <div class="card-header text-center d-none">
            <span class="h1"><b>RSG</b>-mAnoL</span>
        </div>
        <div class="card-body ">
            <div class="text-center">
                <img src="{{ asset('images/logo.webp') }}" style="width:150px"  alt="nologo"/>
                <p class="login-box-msg">Register a new membership</p>
            </div>
            @include('notification.index')
            <form class="form" method="POST" action="{{ route('/user/register') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="name" placeholder="Full name" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <input type="email" class="form-control" name="email" placeholder="Email" required>

                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>

                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Retype password" required>

                </div>


                <div class="input-group mb-3" hidden>
                    <img class="single-upload-img-show" id="img_incident" style="object-fit:contain"
                src="{{asset('/gallery/img/no-image1.jpg')}}" alt="Browse image" width="100%"
                height="150px" />
                <input type="file" class="file-upload d-none" name="image" accept="image/*" capture
                onchange="readURL(this);" id="choose_image">
                </div>

                <div class="row mb-2">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{route('login')}}" style="text-align:left !important">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
@endsection

@push('scripts')
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var getData = e.target.result.split(':')[0];
                    var getType = e.target.result.split(':')[1];
                    var typeResult = getType.split('/')[0];
                    if (typeResult === 'image') {
                        $('#img_incident').attr('src', e.target.result);
                    } else {}


                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    $(function(){
        $('#img_incident').click(function(e) {
            $('#choose_image').trigger('click');
        });
    });
</script>
@endpush
