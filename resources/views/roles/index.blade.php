@extends('layouts.app', [
'class' => '',
'elementActive' => 'roles'
])

@section('content')
<style>
.role-name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 0px;
}

.role-module-name a {
    color: #ffffff;
}

.module-name {
    font-size: 13px;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8 add-role-font">
                            <h3 class="mb-0">{{ __('Roles') }}</h3>
                        </div>
                        <div class="col-4 text-right add-role">
                            <a href="{{ route('role.create') }}" class="btn btn-sm btn-primary" id="add-role">{{
                                __('Add Role') }}</a>
                        </div>
                    </div>
                </div>

                @include('notification.index')
                <div class="card-body">
                    <table id="tblRoleData" class="table table-responsive-sm table-flush display"
                        style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 70%;">{{ __('Name') }}</th>
                                <th scope="col" style="width:20%;">{{ __('Creation Date') }}</th>
                                <th scope="col" style="width:10%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <div>
                                        <p class="role-name">
                                            <?= $role->name; ?>
                                        </p>
                                        <p class="role-modules">
                                            Modules :
                                            <?php if( isset($group_permissions[$role->id]) ){ ?>
                                            <?php foreach($group_permissions[$role->id] as $module){ ?>
                                            <spam class="badge badge-info module-name">
                                                <?= $module; ?>
                                            </spam>
                                            <?php } ?>
                                            <?php }else{ ?>
                                            -
                                            <?php } ?>
                                        </p>
                                    </div>
                                </td>
                                <td>{{ $role->created_at->format('M d, Y h:i a') }}</td>
                                <td class="text-right" style="display: flex;
                                align-items: center;">
                                    @if (Auth::user()->can('role-edit'))
                                        <a class="btn btn-info btn-sm"
                                    href="{{ route('role.edit', $role) }}"><i class="fas fa-pen"></i></a>
                                    @endif
                                    
                                    @if (Auth::user()->can('role-delete'))
                                        <form action="{{ route('role.destroy', $role) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button"
                                                class="btn btn-danger btn-sm"
                                                onclick="confirm('{{ __("Are you sure you want to delete this role?") }}')
                                                            ? this.parentElement.submit() : ''"><i
                                                    class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tblRoleData').DataTable();

    
});
</script>
@endpush