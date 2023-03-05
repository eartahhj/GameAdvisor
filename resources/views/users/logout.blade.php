@extends('layouts.base')

@section('title') {{ _('Logout') }} @endsection

@section('content')

<section class="template-default template-user">
    <div class="container">
        <x-flash-message />

    </div>
</section>

@endsection