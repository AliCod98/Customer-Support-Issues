<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateIssueRequest;
use App\Mail\NewIssueAdminNotification;
use App\Mail\NewIssueCustomerNotification;
use App\Mail\NewIssueStatusCustomerNotification;
use App\Models\Category;
use App\Models\Issue;
use App\Models\Media;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('issue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if ($user->isAdmin()) {
            $issues = Issue::with('user', 'category')->get();
        } else {
            $issues = Issue::where('author_id', $user->id)->with('user', 'category')->get();
        }

        $categories = Category::all();

        return view('admin.issues.index', compact('user', 'issues', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('issue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        $categories = Category::all();

        return view('admin.issues.create', compact('user', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('issue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        $adminUsers = Role::where('title', 'admin')->firstOrFail()->users;

        $issue = Issue::create($request->all());

        if ($request->hasfile('attachments')) {

            $attachments = $request->file('attachments');

            foreach ($attachments as $attachment) {
                $name = $attachment->getClientOriginalName();
                $size = $attachment->getSize();
                $type = $attachment->getClientMimeType();
                $path = 'attachments';
                $attachment->move($path, $name);
                if ($size >= 1048576) {
                    $size = number_format($size / 1048576, 2) . ' MB';
                } else {
                    $size = number_format($size / 1024, 2) . ' KB';
                }
                if ($type == 'application/pdf') {
                    Media::create([
                        'issue_id' => $issue->id,
                        'path' => $path,
                        'filename' => $name,
                        'type' => 'pdf',
                        'size' => $size,
                    ]);
                } else {
                    Media::create([
                        'issue_id' => $issue->id,
                        'path' => $path,
                        'filename' => $name,
                        'type' => 'image',
                        'size' => $size,
                    ]);
                }
            }
        }
        Mail::to($user->email)->send(new NewIssueCustomerNotification($issue));
        foreach ($adminUsers as $admin) {
            Mail::to($admin->email)->send(new NewIssueAdminNotification($issue));
        }
        return redirect()->route('admin.issues.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        abort_if(Gate::denies('issue_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $issue = $issue->load('user', 'category', 'comments', 'medias');

        return view('admin.issues.show', compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        abort_if(Gate::denies('issue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        $issue = $issue->load('user', 'category', 'comments', 'medias');

        $categories = Category::all();

        return view('admin.issues.edit', compact('user', 'issue', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        abort_if(Gate::denies('issue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        $status = $issue->status;

        $issue->update($request->all());


        if ($status != $request->status) {
            if ($user->isAdmin()) {
                Mail::to($issue->user->email)->send(new NewIssueStatusCustomerNotification($issue));
            } else {
                $adminUsers = Role::where('title', 'admin')->firstOrFail()->users;
                foreach ($adminUsers as $admin) {
                    Mail::to($admin->email)->send(new NewIssueStatusCustomerNotification($issue));
                }
            }
        }

        return redirect()->route('admin.issues.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        abort_if(Gate::denies('issue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $issue->delete();

        return back();
    }

    public function storeComment(Request $request, Issue $issue)
    {
        $request->validate([
            'comment_text' => 'required'
        ]);
        $user = auth()->user();
        $comment = $issue->comments()->create([
            'author_id'       => $user->id,
            'comment_text'  => $request->comment_text
        ]);

        $issue->sendCommentNotification($comment);

        return redirect()->back()->withStatus('Your comment added successfully');
    }
}