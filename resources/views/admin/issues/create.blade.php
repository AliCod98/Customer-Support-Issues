@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.Issue.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.issues.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="author_id" name="author_id" class="form-control" value="{{ $user->id }}">
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ trans('cruds.Issue.fields.title') }}*</label>
                <input type="text" id="title" name="title" class="form-control"
                    value="{{ old('title', isset($issue) ? $issue->title : '') }}" required>
                @if($errors->has('title'))
                <em class="invalid-feedback">
                    {{ $errors->first('title') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.Issue.fields.title_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                <label for="content">{{ trans('cruds.Issue.fields.content') }}</label>
                <textarea id="content" name="content"
                    class="form-control ">{{ old('content', isset($issue) ? $issue->content : '') }}</textarea>
                @if($errors->has('content'))
                <em class="invalid-feedback">
                    {{ $errors->first('content') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.Issue.fields.content_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('attachments') ? 'has-error' : '' }}">
                <label for="attachments">{{ trans('cruds.Issue.fields.attachments') }}</label>
                <div class="needsclick dropzone" id="attachments-dropzone">
                    <input type="file" name="attachments[]" multiple class="form-control" accept="image/*">
                    @if ($errors->has('files'))
                    @foreach ($errors->get('files') as $error)
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $error }}</strong>
                    </span>
                    @endforeach
                    @endif
                </div>
                @if($errors->has('attachments'))
                <em class="invalid-feedback">
                    {{ $errors->first('attachments') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.Issue.fields.attachments_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                <label for="category">{{ trans('cruds.Issue.fields.category') }}*</label>
                <select name="category_id" id="category_id" class="form-control select2" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->title }}
                    </option>
                    @endforeach
                </select>
                @if($errors->has('category_id'))
                <em class="invalid-feedback">
                    {{ $errors->first('category_id') }}
                </em>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
@stop