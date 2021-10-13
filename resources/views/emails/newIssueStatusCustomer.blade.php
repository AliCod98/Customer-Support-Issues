@extends('minty')

@section('content')

@include('minty.contentStart')
<tr>
    <td class="title">
        Welcome
    </td>
</tr>
<tr>
    <td width="100%" height="10"></td>
</tr>
<tr>
    <td class="paragraph">
        A Status of issue <b>{{ $issue->title }}</b> has been updated to <b>{{ $issue->status }}</b>
    </td>
</tr>
@include('minty.contentEnd')

@stop