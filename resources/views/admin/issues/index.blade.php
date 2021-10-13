@extends('layouts.admin')
@section('content')

@can('issue_create')
@foreach($user->roles as $role)
@if($role->id == 2)
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.issues.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.Issue.title_singular') }}
        </a>
    </div>
</div>
@endif
@endforeach
@endcan

<div class="card">
    <div class="card-header">
        <h3>{{ trans('cruds.Issue.title_singular') }} {{ trans('global.list') }}</h3>
    </div>
    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Issue">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Title
                </th>
                <th>
                    Content
                </th>
                <th>
                    Status
                </th>
                <th>
                    Category
                </th>
                <th>
                    Author
                </th>
                <th>
                    Created At
                </th>
                <th>
                    Actions
                </th>
            </tr>

            @foreach($issues as $issue)
            <tr>
                <td>
                    {{ $issue->id }}
                </td>
                <td>
                    {{ $issue->title }}
                </td>
                <td>
                    {{ $issue->content }}
                </td>
                <td>
                    {{ $issue->status }}
                </td>
                <td>
                    {{ $issue->category->title }}
                </td>
                <td>
                    {{ $issue->user->name }}
                </td>
                <td>
                    {{ $issue->created_at }}
                </td>
                <td>
                    <form action="{{ route('admin.issues.destroy', $issue->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('admin.issues.show',$issue->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('admin.issues.edit',$issue->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>


    </div>
</div>
@endsection
@section('scripts')
@parent
@endsection