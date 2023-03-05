@extends('layouts.base')

@section('content')
<section class="template-default template-dashboard">
    <div class="container">
        <x-flash-message />

        <h1 class="title is-2">{{ $pageTitle }}</h1>
    
        <p>{{ _('Welcome') . ' ' . auth()->user()->name }}.</p>
        @if (!auth()->user()->email_verified_at)
            <p class="mt-4">{{ _('Your account is not verified yet!')}} </p>
            <p><a href="{{ route('verification.notice') }}">{{ _('Resend verification email')}}</a></p>
        @endif
    </div>
</section>

@endsection
