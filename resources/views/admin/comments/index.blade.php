@extends('layouts.admin')
@section('content')
@can('comment_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.comments.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.comment.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.comment.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Comment">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.comment.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.comment.fields.issue') }}
                        </th>
                        <th>
                            {{ trans('cruds.comment.fields.author_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.comment.fields.comment_text') }}
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr data-entry-id="{{ $comment->id }}">
                        <td>
                            {{ $comment->id ?? '' }}
                        </td>
                        <td>
                            {{ $comment->issue->title ?? '' }}
                        </td>
                        <td>
                            {{ $comment->user->name ?? '' }}
                        </td>
                        <td>
                            {{ $comment->comment_text ?? '' }}
                        </td>
                        <td>
                            @can('comment_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.comments.show', $comment->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan

                            @if($comment->author_id == $user->id)
                            @can('comment_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.comments.edit', $comment->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan

                            @can('comment_delete')
                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                            @endcan
                            @endif

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