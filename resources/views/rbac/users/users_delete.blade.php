@extends('adminlte::page')

@section('content')

    <main role="main" class="col-md-12 ml-sm-auto pt-3 px-4">

    <a class="btn btn-sm btn-primary" href="{{route('users.index')}}">@lang('rbac.b_back')</a>
    <h2>{{$title}}</h2>
    <div class="clearfix"></div>
    <p>@lang('rbac.sure_delete', ['name' => $user->name])</p>

                    <form method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}">
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="btn btn-danger">@lang('rbac.b_sure_delete')</button>
                    </form>
</main>
</div>
</div>
@endsection