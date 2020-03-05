@extends('adminlte::page')

@section('content')
<main role="main" class="col-md-12 ml-sm-auto pt-3 px-4">
  
      <a class="btn btn-sm btn-primary" href="{{route('roles.create')}}">@lang('rbac.b_add_role')</a>
      <h2>{{$title}}</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>@lang('rbac.role_display')</th>
              <th>@lang('rbac.role_desc')</th>
              <th>@lang('rbac.user_table_role')</th>
              <th>@lang('rbac.action')</th>
            </tr>
          </thead>
          <tbody>
              @foreach($roles as $role)
              <tr>
                <td>{{ $role->display_name }}</td>
                <td>{{ $role->description }}</td>
                <td>{{ $role->name }}</td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="{{ route('roles.edit', ['role' => $role->id]) }}" class="btn btn-info btn-xs"><i class="fas fa-pencil-alt" title="@lang('rbac.permissions')"></i> </a>
                    <a class="btn btn-danger" href="{{ route('roles.show', ['role' => $role->id]) }}" class="btn btn-danger btn-xs"><i class="fas fa-trash" title="@lang('rbac.delete')"></i> </a>
                  </div>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        {{ $roles->links() }}
      </div>
    </main>
  </div>
</div>
@endsection