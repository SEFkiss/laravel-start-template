@extends('adminlte::page')

@section('content')
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
<main role="main" class="col-md-12 ml-sm-auto pt-3 px-4">

    <a class="btn btn-sm btn-primary" href="{{route('permission.index')}}">@lang('rbac.b_back')</a>
    <h2>{{$title}}</h2>
    <form method="post" action="{{ route('permission.update', ['permission' => $permission->id]) }}" data-parsley-validate class="form-horizontal form-label-left">

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} row">
            <label for="name" class="col-sm-2 col-form-label">@lang('rbac.name_use')</label>
            <div class="col-sm-10">
                <input type="text" value="{{$permission->name}}" id="name" name="name" class="form-control col-md-7 col-xs-12"> @if ($errors->has('name'))
                <span class="help-block">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }} row">
            <label for="display_name" class="col-sm-2 col-form-label">@lang('rbac.display_name')</label>
            <div class="col-sm-10">
                <input type="text" value="{{$permission->display_name}}" id="display_name" name="display_name" class="form-control col-md-7 col-xs-12"> @if ($errors->has('display_name'))
                <span class="help-block">{{ $errors->first('display_name') }}</span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} row">
            <label for="description" class="col-sm-2 col-form-label">@lang('rbac.desc')</label>
            <div class="col-sm-10">
                <input type="text" value="{{$permission->description}}" id="description" name="description" class="form-control col-md-7 col-xs-12"> @if ($errors->has('description'))
                <span class="help-block">{{ $errors->first('description') }}</span>
                @endif
            </div>
        </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <input name="_method" type="hidden" value="PUT">
                <button type="submit" class="btn btn-success">@lang('rbac.b_update_perm_act')</button>
            </div>
        </div>
    </form>
</main>
</div>
</div>

@endsection