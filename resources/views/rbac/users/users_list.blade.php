@extends('adminlte::page')

@section('content')
   
    <main role="main" class="col-md-12 ml-sm-auto pt-3 px-4">
      
      
      <a class="btn btn-sm btn-primary" href="{{route('users.create')}}">@lang('rbac.b_add_new_user')</a>
      <h2>{{$title}}</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>@lang('rbac.user_table_username')</th>
              <th>@lang('rbac.user_table_email')</th>
              <th>@lang('rbac.user_table_role')</th>
              <th>@lang('action')</th>
            </tr>
          </thead>
          <tbody>
              @foreach($users as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                    @foreach($user->roles as $r)
                        {{$r->display_name}}
                    @endforeach
                    </td>
                    @php
                        //var_dump($user->id);die;
                    @endphp
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-info btn-xs"><i class="fas fa-pencil-alt" title="@lang('rbac.role')"></i> </a>
                        <a class="btn btn-danger" href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn-danger btn-xs"><i class="fas fa-trash" title="@lang('rbac.delete')"></i> </a>
                      </div>
                    </td>
                  </tr>
                  @endforeach
          </tbody>
        </table>
        {{ $users->links() }}
      </div>
    </main>
  </div>
</div>
@endsection