@extends('layouts.base')

@section('title') {{ _('New game') }} @endsection

@section('content')

<section class="template-default template-games">
    <div class="container">
        <h1>{{ _('Insert a new game') }}</h1>

        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif

        <x-flash-message />

        <form action="{{ route('games.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="field">
                @error('title')
                    @include('forms.message', ['class' => 'is-danger', 'text' => _('Error:') . ' ' . $message])
                @enderror
                <label for="games-create-title" class="label">{{ _('Title') }}</label>
                <input id="games-create-title" type="text" name="title" value="{{ old('title') }}" class="input" required="required">
            </div>

            <div class="field">
                @error('description')
                    <x-form-error>
                        <x-slot:text>
                            {{ _('Error:') . ' ' . $message }}
                        </x-slot>
                    </x-form-error>
                @enderror
                <label for="games-create-description" class="label">{{ _('Text') }}</label>
                <textarea id="games-create-description" name="description" rows="10" cols="40" class="textarea">{{ old('text') }}</textarea>
            </div>

            <div class="field">
                @error('platform_id')
                    @include('forms.message', ['class' => 'is-danger', 'text' =>  _('Error:') . ' ' . $message])
                @enderror
                <label for="games-create-platform" class="label">{{ _('Platform') }}</label>
                <select id="games-create-platform" name="platform_id" required="required">
                    <option value="1">PC</option>
                    <option value="2">PS</option>
                </select>
            </div>

            <div class="field">
                @error('image')
                    @include('forms.message', ['class' => 'is-danger', 'text' =>  _('Error:') . ' ' . $message])
                @enderror
                <label for="games-create-image" class="label">{{ _('Image') }}</label>
                <input id="games-create-image" type="file" name="image" class="input">
            </div>

            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    </div>
</section>

@endsection
