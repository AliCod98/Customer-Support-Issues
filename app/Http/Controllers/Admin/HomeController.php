<?php

namespace App\Http\Controllers\Admin;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dashboard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //
        $user = Auth::user();

        if ($user->isAdmin()) {
            $totalIssues = Issue::count();
            $submittedIssues = Issue::where('status', 'Submitted')->count();
            $progressIssues = Issue::where('status', 'In Progress')->count();
            $resolvedIssues = Issue::where('status', 'Resolved')->count();
            $closedIssues = Issue::where('status', 'Closed')->count();
        } else {
            $totalIssues = Issue::where('author_id', $user->id)->count();
            $submittedIssues = Issue::where('author_id', $user->id)->where('status', 'Submitted')->count();
            $resolvedIssues = Issue::where('author_id', $user->id)->where('status', 'Resolved')->count();
            $progressIssues = 0;
            $closedIssues = 0;
        }

        return view('home', compact('user', 'totalIssues', 'submittedIssues', 'progressIssues', 'resolvedIssues', 'closedIssues'));
    }
}