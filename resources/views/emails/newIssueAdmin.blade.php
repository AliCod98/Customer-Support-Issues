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
        Your are recieved a new issue
    </td>
</tr>
<tr>
    <td class="paragraph">
        Your are recieved a new issue : {{ $issue->title }}
    </td>
</tr>
@include('minty.contentEnd')

@stop