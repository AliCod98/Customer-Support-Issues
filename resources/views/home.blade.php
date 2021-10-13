@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($totalIssues) }}</div>
                                    <div>Total issues</div>
                                    <br />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($submittedIssues) }}</div>
                                    <div>Submitted issues</div>
                                    <br />
                                </div>
                            </div>
                        </div>

                        @if($user->isAdmin())
                        <div class="col-md-4">
                            <div class="card text-white bg-danger">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($progressIssues) }}</div>
                                    <div>In progress issues</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-4">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($resolvedIssues) }}</div>
                                    <div>Resolved issues</div>
                                    <br />
                                </div>
                            </div>
                        </div>

                        @if($user->isAdmin())
                        <div class="col-md-4">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($closedIssues) }}</div>
                                    <div>Closed issues</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection