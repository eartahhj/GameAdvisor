@extends('layouts.base')

@section('title') {{ _('Edit review') }} @endsection

@section('content')
<section class="template-default template-reviews">
    <div class="container">
        <h2>{{ _('Edit review') }}</h2>
        <p>{{ _('Review:') . ' ' . $review->title }}</p>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />
    
        <form action="{{ route('reviews.store', $review->game_id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="field">
                @error('title')
                <x-form-error>
                    <x-slot:text>
                        {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="reviews-edit-title" class="label">{{ _('Title') }}</label>
                <input id="reviews-edit-title" type="text" name="title" value="{{ $review->title }}" class="input">
            </div>
    
            <div class="field">
                @error('text')
                <x-form-error>
                    <x-slot:text>
                        {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="reviews-edit-text" class="label">{{ _('Text') }}</label>
                <textarea id="reviews-edit-text" name="text" rows="10" cols="40" class="textarea">{{ $review->text }}</textarea>
            </div>
    
            <div class="field">
                @error('approved')
                <x-form-error>
                    <x-slot:text>
                        {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <fieldset>
                    <legend>{{ _('Approved') }}</legend>
                    <input type="radio" name="approved" id="reviews-edit-approved-t" class="radio" value="true"{{ $review->approved ? ' checked="checked' : '' }}>
                    <label for="reviews-edit-approved-t" class="radio">{{ _('Yes') }}</label>
                    <input type="radio" name="approved" id="reviews-edit-approved-f" class="radio" value="false"{{ $review->approved ? '' : ' checked="checked' }}>
                    <label for="reviews-edit-approved-f" class="radio">{{ _('No') }}</label>
                </fieldset>
            </div>
    
            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    
        <p>
            <a href="{{ route('reviews.create', $review->game_id) }}" class="button is-primary">{{ _('Create new') }}</a>
        </p>
    
        <form action="{{ route('reviews.index', $review)}}" method="post">
            @csrf
            @method('DELETE')
    
            <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')" class="button is-danger">{{ _('Delete') }}</button>
        </form>
    </div>
</section>

@endsection
