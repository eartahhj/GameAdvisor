@extends('layouts.base')

@section('content')
<section class="template-default template-standard">
    <div class="container">
        <x-flash-message />
    
        <h1 class="title is-2">{{ $pageTitle }}</h1>
        @if (!auth()->user()->email_verified_at)
            <p>{{ _('You will receive an email to verify your account') }}</p>
            <form class="mt-3" action="{{ route('verification.send') }}" method="post">
                @csrf
                <p>{{ _('Your email') }}: {{ auth()->user()->email }}</p>
                <p class="buttons mt-2">
                    <button class="button is-primary" type="submit" name="send">{{ _('Send email')}}</button>
                </p>
            </form>
        @else
            <p>{{ _('Your email has already been verified') }}</p>
        @endif
    </div>
</section>
@endsection
