@extends('layouts.base')

@section('content')
<section class="template-default template-admin">
    <div class="container">
        <x-flash-message />
        
        <div class="box">
            <x-page-title :text="$pageTitle"></x-page-title>

            @if ($errors->any())
                @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
            @endif
    
            <x-flash-message />            
            
            @include('pages.form-create')
        </div>
    </div>
</section>

@endsection