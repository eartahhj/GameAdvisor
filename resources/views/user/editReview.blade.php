@extends('layouts.base')

@section('content')
<section class="template-default template-reviews">
    <div class="container">
        <x-page-title :text="$pageTitle"></x-page-title>

        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />

        <x-messages.info>
            <x-slot:text>{{ _('Please note that by editing your review it will need to be approved again'); }}</x-slot:text>
        </x-messages.info>
    
        <form id="form-edit" action="{{ route('user.review.update', $review->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="field">
                @error('title')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <label for="reviews-edit-title" class="label">{{ _('Title') }}</label>
                <input id="reviews-edit-title" type="text" name="title" value="{{ old('title', $review->title) }}" class="input">
            </div>

            <x-reviews.form-field-rating :currentRating="$review->rating"></x-reviews.form-field-rating>
    
            <div class="field">
                @error('text')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <label for="reviews-edit-text" class="label">{{ _('Text') }}</label>
                <textarea id="reviews-edit-text" name="text" rows="10" cols="40" class="textarea">{{ old('text', $review->text) }}</textarea>
            </div>

            @if (auth()->user()->email_verified_at)
            <x-form-image-field name="image" :help="$supportedImageFormats" :image="$image" :filename="$review->image"></x-form-image-field>
            @endif
        </form>
    
        <form id="form-delete" action="{{ route('user.review.delete', $review)}}" method="post">
            @csrf
            @method('DELETE')
        </form>

        <p class="buttons">
            <button type="submit" name="send" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-check"></i></span>
                <span>{{ _('Save') }}</span>
            </button>
            <a href="{{ route('reviews.create', $review->game_id) }}" class="button is-primary">
                <span class="icon is-small"><i class="fas fa-plus"></i></span>
                <span>{{ _('Create new') }}</span>
            </a>
            <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this review?') }}')" class="button is-danger" form="form-delete">
                <span class="icon is-small"><i class="fas fa-trash"></i></span>
                <span>{{ _('Delete') }}</span>
            </button>
        </p>
    </div>
</section>

@endsection
