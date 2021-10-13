@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.comment.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.comments.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('issue_id') ? 'has-error' : '' }}">
                <label for="issue">{{ trans('cruds.comment.fields.issue') }}</label>
                <select name="issue_id" id="issue" class="form-control select2">
                    @foreach($issues as $id => $issue)
                    <option value="{{ $id }}"
                        {{ (isset($comment) && $comment->issue ? $comment->issue->id : old('issue_id')) == $id ? 'selected' : '' }}>
                        {{ $issue }}
                    </option>
                    @endforeach
                </select>
                @if($errors->has('issue_id'))
                <em class="invalid-feedback">
                    {{ $errors->first('issue_id') }}
                </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('author_id') ? 'has-error' : '' }}">
                <label for="author_id">{{ trans('cruds.comment.fields.author_name') }}*</label>
                <input type="text" id="author_name" name="author_name" class="form-control" value="{{ $user->name }}"
                    disabled>
                <input type="hidden" id="author_id" name="author_id" class="form-control" value="{{ $user->id }}">

            </div>

            <div class="form-group {{ $errors->has('comment_text') ? 'has-error' : '' }}">
                <label for="comment_text">{{ trans('cruds.comment.fields.comment_text') }}*</label>
                <textarea id="comment_text" name="comment_text" class="form-control "
                    required>{{ old('comment_text', isset($comment) ? $comment->comment_text : '') }}</textarea>
                @if($errors->has('comment_text'))
                <em class="invalid-feedback">
                    {{ $errors->first('comment_text') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.comment.fields.comment_text_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection