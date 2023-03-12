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
            
            <form action="{{ route('cookieConsent.modify')}}" method="post" enctype="multipart/form-data">
                @csrf
                
                <fieldset class="improved">
                    <legend>{{ _('Your consent') }}</legend>

                    <div class="form-inline">
                        <label class="checkbox" disabled>
                            <input type="checkbox" disabled checked="checked">
                            {{ _('Technical cookies (necessary)') }}
                        </label>
    
                        <label class="checkbox">
                            <input type="checkbox" name="ads" value="true"{{ ($adsEnabled ? ' checked="checked' : '') }}>
                            {{ _('Ads cookies') }}
                        </label>
                    </div>
                </fieldset>

                <p>
                    <a href="{{ page_url(4) }}">{{ _('Read the full cookie policy') }}</a>
                </p>
            
                <div class="buttons mt-5">
                    <button type="submit" class="button is-success"><?=_('Save')?></button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection