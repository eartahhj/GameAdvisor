@extends('layouts.base')

@section('title') {{ _('Verify your account') }} @endsection

@section('content')

<div class="container">
    <x-flash-message />

    @if (!auth()->user()->email_verified_at)
        <p class="subtitle is-3">{{ _('Verify your account') }}</p>
        <p>{{ _('You will receive an email to verify your account') }}</p>
        <form class="" action="{{ route('verification.send') }}" method="post">
            @csrf
            <p>{{ _('Your email') }}: {{ auth()->user()->email }}</p>
            <button type="submit" name="send">{{ _('Send email')}}</button>
        </form>
    @else
        <p>{{ _('Your email has already been verified') }}</p>
    @endif

</div>

@endsection
