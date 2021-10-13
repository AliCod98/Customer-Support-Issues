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
        {{ trans('global.show') }} {{ trans('cruds.Issue.title') }}
    </div>

    <div class="card-body">
        @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>
                            {{ $issue->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>Created At </th>
                        <td>
                            {{ $issue->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td> {{ $issue->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>Content </th>
                        <td>
                            {{ $issue->content }}
                        </td>
                    </tr>
                    <tr>
                        <th>Attachments </th>
                        <td>
                            <div class="needsclick dropzone" id="attachments-dropzone d-flex">@forelse ($issue->medias
                                as $media) @if($media->type=="image") <img
                                    src="{{ asset('attachments/'.$media->filename) }}" alt="{{ $media->filename }}"
                                    style="width:100px;min-height:10px;margin-right:6px;">@elseif($media->type=="pdf")
                                <iframe src="{{ asset('attachments/'.$media->filename) }}" frameborder="0"
                                    style="width:100px;min-height:10px;margin-right:6px;"></iframe>@endif @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Status </th>
                        <td>
                            {{ $issue->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>Category </th>
                        <td>
                            {{ $issue->category->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>Author </th>
                        <td>
                            {{ $issue->user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Comments </th>
                        <td>
                            @forelse($issue->comments as $comment)
                            <div class="row">
                                <div class="col">
                                    <p class="font-weight-bold">
                                        <a href="mailto:{{ $comment->user->email }}">{{ $comment->user->name }}</a>
                                        ({{$comment->created_at }})
                                    </p>
                                    <p>
                                        {{ $comment->comment_text }}
                                    </p>
                                </div>
                            </div>
                            <hr />
                            @empty
                            <div class="row">
                                <div class="col">
                                    <p>There are no comments.</p>
                                </div>
                            </div>
                            <hr />
                            @endforelse
                            <form action="{{ route('admin.issues.storeComment', $issue->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="comment_text">Leave a comment</label>
                                    <textarea class="form-control" id="comment_text" name="comment_text" rows="3"
                                        required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a class="btn btn-default my-2" href="{{ route('admin.issues.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
        <a href="{{ route('admin.issues.edit', $issue->id) }}" class="btn btn-primary">
            @lang('global.edit')
            @lang('cruds.Issue.title_singular') </a>
        <nav class="mb-3">
            <div class="nav nav-tabs"></div>
        </nav>
    </div>
</div>
@endsection