<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CommentsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if ($user->isAdmin()) {
            $comments = Comment::all();
        } else {
            $issues = Issue::where('author_id', $user->id)->get();
            foreach ($issues as $issue) {
                $comments = Comment::where('issue_id', $issue->id)->get();
            }
        }

        return view('admin.comments.index', compact('comments', 'user'));
    }

    public function create()
    {
        abort_if(Gate::denies('comment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if ($user->isAdmin()) {
            $issues = Issue::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else {
            $issues = Issue::where('author_id', $user->id)->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        return view('admin.comments.create', compact('issues', 'user'));
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->all());

        return redirect()->route('admin.comments.index');
    }

    public function edit(Comment $comment)
    {
        abort_if(Gate::denies('comment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $issues = Issue::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $comment->load('issue', 'user');

        return view('admin.comments.edit', compact('issues', 'users', 'comment'));
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());

        return redirect()->route('admin.comments.index');
    }

    public function show(Comment $comment)
    {
        abort_if(Gate::denies('comment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comment->load('issue', 'user');

        return view('admin.comments.show', compact('comment'));
    }

    public function destroy(Comment $comment)
    {
        abort_if(Gate::denies('comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comment->delete();

        return back();
    }
}