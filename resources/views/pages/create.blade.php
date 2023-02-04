@extends('layouts.base')

@section('title') {{ _('New page') }} @endsection

@section('content')

<section class="template-default template-admin">
    <div class="container">
        <x-flash-message />
        
        <div class="box">
            <h1 class="title is-2"><?= _('Create a new page') ?></h1>

            @if ($errors->any())
                @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
            @endif
    
            <x-flash-message />            
            
            @include('pages.form-create')
        </div>
    </div>
</section>

@endsection