@extends('layouts.base')

@section('title') {{ _('New review') }} @endsection

@section('content')

<section class="template-default template-reviews">
    <div class="container">
        <header class="section-header">
            <x-flash-message />
            <p class="title is-3">{!! sprintf(_('Write a review about %s'), $gameLink) !!}</p>
            <p class="subtitle is-5">{{ _('Please note that all reviews will be subject to approval before being published.') }}</p>
    
            @if (!empty(auth()->user()->id))
            <p><?=sprintf(_('You are creating a new review as %s'), '<strong>' . htmlspecialchars(($authorName ? $authorName : $authorEmail)) . '</strong>')?></p>
            @else
            <p>{{ _('You are creating a new anonymous review') }}</p>
            @endif
        </header>
    
        <div class="box">
            @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
            @endif
    
            <form action="{{ route('reviews.store', $game->id)}}" method="post" enctype="multipart/form-data">
                @csrf
    
                <p class="mb-2">{{ sprintf(_('Fields marked with %s are mandatory'), _('*')) }}</p>
    
                <fieldset>
                    <legend>{{ _('Review')}}</legend>
    
                    <div class="field">
                        @error('title')
                        <x-form-error>
                            <x-slot:text>
                                {{ $message }}
                                </x-slot>
                        </x-form-error>
                        @enderror
                        <label for="reviews-create-title" class="label">{{ _('Title') }} {{ _('*') }}</label>
                        <input id="reviews-create-title" type="text" name="title" value="{{ old('title') }}" class="input">
                    </div>
    
                    <fieldset>
                        <legend class="label">{{ _('Rating') }} {{ _('*') }}</legend>
    
                        <div id="rating-radiolist" class="field">
                            @error('rating')
                            <x-form-error>
                                <x-slot:text>
                                    {{ $message }}
                                    </x-slot>
                            </x-form-error>
                            @enderror
    
                            <div class="control radiolist">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input id="reviews-create-rating-{{$i}}" type="radio" name="rating" value="{{$i}}"{{ (old('rating') == $i ? ' checked="checked"' : '')}} tabindex="-1" class="sr-only" aria-labelledby="radio-rating-{{$i}}-label" required="required">
                                @endfor
    
                                <div class="labels">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label id="radio-rating-{{$i}}-label" class="radio radio-rating-{{$i}}" for="reviews-create-rating-{{$i}}" tabindex="0">
                                            <span class="radiolist-radio-label sr-only">{{$i}} {{ ($i == 1 ? _('star') : _('stars')) }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </fieldset>
    
                    <div class="field">
                        @error('text')
                        <x-form-error>
                            <x-slot:text>
                                {{ $message }}
                                </x-slot>
                        </x-form-error>
                        @enderror
    
                        <label for="reviews-create-text" class="label">{{ _('Text') }} {{ _('*') }}</label>
                        <textarea id="reviews-create-text" name="text" rows="10" cols="40" class="textarea" required="required">{{ old('text') }}</textarea>
                    </div>
                </fieldset>
    
                <fieldset>
                    <legend>{{ _('Author') }}</legend>
    
                    <div class="field">
                        @error('author_name')
                        <x-form-error>
                            <x-slot:text>
                                {{ $message }}
                                </x-slot>
                        </x-form-error>
                        @enderror
                        <label for="reviews-create-author_name" class="label">{{ _('Your name') }} {{ _('(optional)')}}</label>
                        <p class="control has-icons-left has-icons-right">
                            <input id="reviews-create-author_name" type="text" name="author_name" value="{{ $authorName }}" class="input" {!! $authorName ? ' disabled="disabled" readonly="readonly"' : '' !!}>
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                            @if ($authorName)
                                <span class="icon is-small is-right">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        </p>
                    </div>
    
                    <div class="field">
                        @error('author_email')
                        <x-form-error>
                            <x-slot:text>
                                {{ $message }}
                                </x-slot>
                        </x-form-error>
                        @enderror
                        <label for="reviews-create-author_email" class="label">{{ _('Your email') }} {{ _('(optional)')}}</label>
                        <p class="control has-icons-left has-icons-right">
                            <input id="reviews-create-author_email" type="email" name="author_email" value="{{ $authorEmail }}" class="input" {!! $authorEmail ? ' disabled="disabled" readonly="readonly"' : '' !!}>
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                            @if ($authorEmail)
                                <span class="icon is-small is-right">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        </p>
                    </div>
                </fieldset>
    
                <fieldset>
                    <legend>{{ _('Anonymous review')}}</legend>
    
                    @if (!empty(auth()->user()->id))
                    <div class="field">
                        @error('is_anonymous')
                        <x-form-error>
                            <x-slot:text>
                                {{ $message }}
                                </x-slot>
                        </x-form-error>
                        @enderror
                        <label for="reviews-create-is_anonymous" class="checkbox">
                            <input id="reviews-create-is_anonymous" type="checkbox" name="is_anonymous" value="t" class="" {!! old('is_anonymous') ? ' checked="checked"' : '' !!}>
                            {{ _('Make this review anonymous') }}
                        </label>
                        <p><em>{{ _('Your name and email will not be associated to this review.') }}</em></p>
                        @if (!empty(auth()->user()->id))
                            <p class="mt-2">{{ _('You may also logout if you want to be sure to submit an anomyous review.') }} (<a href="{{ route('users.logout') }}" rel="nofollow">{{ _('Logout now') }}</a>)</p>
                        @endif
                    </div>
                    @else
                        <p>{{ _('This review will be anonymous, unless you specify your name or email. You can also create a free account if you wish.') }} <a href="{{ route('users.register.form') }}">{{ _('Register') }}</a></p>
                    @endif
                </fieldset>
    
                <div class="mt-2">
                    <p>{{ _("Nonetheless, please be aware that your IP address is stored in the server's log files and might be retrieved in cases of law infringement, by combining the timestamps of the review and your visit to this website.")}}</p>
                    <p>{{ _('We do our best to grant anonymity when required, but we also hope that one can take their own responsibility for what they decide to write and submit.')}}</p>
                </div>
    
                <div class="buttons">
                    <button type="submit" name="send" class="button is-primary">{{ _('Send') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
