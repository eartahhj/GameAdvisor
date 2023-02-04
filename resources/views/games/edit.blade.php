@extends('layouts.base')

@section('title') {{ _('Edit game') }} @endsection

@section('content')

<section class="template-default template-games">
    <div class="container">
        <x-flash-message />
    
        <h2>{{ _('Edit game') }}</h2>
        <p>{{ _('Game:') . ' ' . $game->title }}</p>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('games.update', $game)}}" method="post" enctype="multipart/form-data" id="form-edit">
            @csrf
            @method('PUT')
            <div class="field">
                @error('name')
                    @include('forms.message', ['class' => 'is-danger', 'text' => _('Error message')])
                @enderror
                <label for="games-edit-title" class="label">{{ _('Title') }}</label>
                <input id="games-edit-title" type="text" name="title" value="{{ $game->title }}" class="input" required="required">
            </div>
    
            <div class="field">
                @error('description')
                    <x-form-error>
                        <x-slot:text>
                        {{ _('Error:') . ' ' . $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="games-edit-description" class="label">{{ _('Text') }}</label>
                <textarea id="games-edit-description" name="description" rows="10" cols="40" class="textarea">{{ $game->description }}</textarea>
            </div>
    
            <div class="field">
                @error('platform_id')
                    @include('forms.message', ['class' => 'is-danger', 'text' => _('Error message')])
                @enderror
                <label for="games-edit-platform" class="label">{{ _('Platform') }}</label>
                <select id="games-edit-platform" name="platform_id" required="required">
                    <option value="1">PC</option>
                    <option value="2">PS</option>
                </select>
            </div>
    
            <div class="field">
                @error('image')
                    @include('forms.message', ['class' => 'is-danger', 'text' => _('Error message')])
                @enderror
                <label for="games-edit-image" class="label">{{ _('Image') }}</label>
                <input id="games-edit-image" type="file" name="image" class="input">
                @if ($game->image and $image)
                    <p>{{ _('Current file:') . ' ' . $game->image }}</p>
                    <figure>
                        <img src="/storage/{{ $game->image }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}">
                    </figure>
                    <p><a href="/storage/{{ $game->image }}">{{ _('View file') }}</a></p>
                @endif
            </div>
        </form>
        
        <form action="{{ route('games.delete', $game) }}" method="post" id="form-delete">
            @csrf
            @method('DELETE')
        </form>
    
        <div class="buttons">
            <button type="submit" name="send" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-check"></i></span>
                <span>{{ _('Save') }}</span>
            </button>
            <button type="button" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-plus"></i></span>
                <span>{{ _('Create new') }}</span>
            </button>
            <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')" class="button is-danger" form="form-delete">
                <span class="icon is-small"><i class="fas fa-trash"></i></span>
                <span>{{ _('Delete') }}</span>
            </button>
        </div>
    </div>
</section>

@endsection
