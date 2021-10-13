@extends('layouts.admin')
@section('content')
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.users.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Username
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Email Verified At
                        </th>
                        <th>
                            Roles
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr data-entry-id="{{ $user->id }}">
                        <td>
                            {{ $user->id ?? '' }}
                        </td>
                        <td>
                            {{ $user->name ?? '' }}
                        </td>
                        <td>
                            {{ $user->email ?? '' }}
                        </td>
                        <td>
                            {{ $user->email_verified_at ?? '' }}
                        </td>
                        <td>
                            @foreach($user->roles as $key => $item)
                            <span class="badge badge-info">{{ $item->title }}</span>
                            @endforeach
                        </td>
                        <td>
                            @can('user_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan

                            @can('user_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $user->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan

                            @can('user_delete')
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                            @endcan

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
@endsection