@extends('adminlte::page')

@section('content')
<main role="main" class="col-md-12 ml-sm-auto  pt-3 px-4">

      <a class="btn btn-sm btn-primary" href="{{route('permission.create')}}">@lang('rbac.b_create_perm')</a>
      <h3>{{$title}}</h3>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>@lang('rbac.name_use')</th>
              <th>@lang('rbac.display_name')</th>
              <th>@lang('rbac.desc')</th>
              <th>@lang('rbac.action')</th>
            </tr>
          </thead>
          <tbody>
              @foreach($permissions as $row)
              <tr>
                <td>{{ $row->name }}</td>
                <td>{{ $row->display_name }}</td>
                <td>{{ $row->description }}</td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="{{ route('permission.edit', ['permission' => $row->id]) }}" class="btn btn-info btn-xs"><i class="fas fa-pencil-alt" title="@lang('rbac.edit')"></i> </a>
                    <a class="btn btn-danger" href="{{ route('permission.show', ['permission' => $row->id]) }}" class="btn btn-danger btn-xs"><i class="fas fa-trash" title="@lang('rbac.delete')"></i> </a>
                  </div>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        {{ $permissions->links() }}
      </div>
    </main>
  </div>
</div>

@endsection