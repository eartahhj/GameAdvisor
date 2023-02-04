@extends('layouts.base')

@section('title') {{ _('Edit developer') }} @endsection

@section('content')
<section class="template-default template-developers">
    <div class="container">
        <x-flash-message />
    
        <h2>{{ _('Edit game developer') }}</h2>
        <p>{{ _('Developer:') . ' ' . $developer->name }}</p>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('developers.update', $developer)}}" method="post" enctype="multipart/form-data" id="form-edit">
            @csrf
            @method('PUT')
            <div class="field">
                @error('name')
                    @include('forms.message', ['class' => 'is-danger', 'text' => _('Error message')])
                @enderror
                <label for="games-edit-name" class="label">{{ _('Name') }}</label>
                <input id="games-edit-name" type="text" name="name" value="{{ $developer->name }}" class="input" required="required">
            </div>
        </form>
    
        <form action="{{ route('developers.delete', $developer) }}" method="post" id="form-delete">
            @csrf
            @method('DELETE')
        </form>
    
        <div class="buttons">
            <button type="submit" name="send" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-check"></i></span>
                <span>{{ _('Save') }}</span>
            </button>
            <a href="{{ route('developers.create') }}" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-plus"></i></span>
                <span>{{ _('Create new') }}</span>
            </a>
            <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')" class="button is-danger" form="form-delete">
                <span class="icon is-small"><i class="fas fa-trash"></i></span>
                <span>{{ _('Delete') }}</span>
            </button>
        </div>
    </div>
</section>

@endsection
