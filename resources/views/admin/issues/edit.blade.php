@extends('layouts.admin')
@section('content')

<style>
.dropzone {
    display: flex;
}

.dropzone img {
    width: 40%;
}
</style>

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.Issue.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route('admin.issues.update', $issue->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control"
                    value="{{ old('title', isset($issue) ? $issue->title : '') }}" disabled>
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
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control "
                    disabled>{{ old('content', isset($issue) ? $issue->content : '') }}</textarea>
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
                <label for="attachments">Attachments</label>
                <div class="needsclick dropzone" id="attachments-dropzone d-flex">
                    @forelse ($issue->medias as $media)
                    @if($media->type == "image")
                    <img src="{{ asset('attachments/'.$media->filename) }}" alt="{{ $media->filename }}"
                        style="width:100px;min-height:10px;margin-right: 6px;">
                    @elseif($media->type == "pdf")
                    <iframe src="{{ asset('attachments/'.$media->filename) }}" frameborder="0"
                        style="width:100px;min-height:10px;margin-right: 6px;"></iframe>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">Status*</label>
                <select name="status" id="status" class="form-control select2" required>
                    @if($user->isAdmin())
                    <option value="Submitted">Submitted
                    </option>
                    <option value="In Progress">In
                        Progress
                    </option>
                    <option value="Resolved">Resolved
                    </option>
                    @endif
                    <option value="Closed">Closed
                    </option>
                </select>
                @if($errors->has('status'))
                <em class="invalid-feedback">
                    {{ $errors->first('status') }}
                </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                <label for="category">Category*</label>
                <input type="text" id="category" name="category" class="form-control"
                    value="{{ $issue->category->title }}" disabled>
                @if($errors->has('category'))
                <em class="invalid-feedback">
                    {{ $errors->first('category') }}
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