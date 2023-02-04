@extends('layouts.base')

@section('title') {{ _('Dashboard') }} @endsection

@section('content')

<section class="template-default template-dashboard">
    <div class="container">
        <x-flash-message />
    
        <p>{{ _('Welcome') . ' ' . auth()->user()->name }}</p>
        @if (!auth()->user()->email_verified_at)
            <p>{{ _('Your account is not verified yet!')}} </p>
            <p><a href="{{ route('verification.notice') }}">{{ _('Resend verification email')}}</a></p>
        @endif
    </div>
</section>

@endsection
