@extends('layouts.base')

@section('content')
<section class="template-default template-reviews">
    <div class="container">
        <h1 class="title is-2">{{ _('Edit review') }}</h1>
        <p>{{ _('Review:') . ' ' . $review->title }}</p>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />
    
        <form id="form-edit" action="{{ route('reviews.update', $review->game_id)}}" method="post" enctype="multipart/form-data">
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

            <x-form-image-field name="image" :help="$supportedImageFormats" :image="$image" :filename="$review->image"></x-form-image-field>

            <div class="field">
                @error('hours_played')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <label for="reviews-edit-hours_played" class="label">{{ _('Hours played') }}</label>
                <input id="reviews-edit-hours_played" type="number" name="hours_played" value="{{ old('hours_played') }}" class="input" step="0.01" min="0">
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

            <p class="mb-3"><strong>{{ _('Approved') }}</strong>: {{ $review->approved ? _('Yes') : _('No') }}</p>
        </form>
    
        <form id="form-delete" action="{{ route('reviews.index', $review)}}" method="post">
            @csrf
            @method('DELETE')
        </form>

        <x-reviews.form-approve :review="$review"></x-reviews>

        <div class="buttons">
            <button type="submit" name="send" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-check"></i></span>
                <span>{{ _('Save') }}</span>
            </button>
            <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')" class="button is-danger" form="form-delete">
                <span class="icon is-small"><i class="fas fa-trash"></i></span>
                <span>{{ _('Delete') }}</span>
            </button>
        </div>
    </div>
</section>

@endsection
