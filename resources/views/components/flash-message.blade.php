@if (session()->has('message'))
    <div class="message is-info">
        <div class="message-header">
            {{ _('Info') }}
        </div>
        <p class="message-body">{{ session('message') }}</p>
    </div>
@endif

@if (session()->has('warning'))
    <div class="message is-warning">
        <div class="message-header">
            {{ _('Warning') }}
        </div>
        <p class="message-body">{{ session('warning') }}</p>
    </div>
@endif

@if (session()->has('confirm'))
    <div class="message is-success">
        <div class="message-header">
            {{ _('Success') }}
        </div>
        <p class="message-body">{{ session('confirm') }}</p>
    </div>
@endif

@if (session()->has('success'))
    <div class="message is-success">
        <div class="message-header">
            {{ _('Success') }}
        </div>
        <p class="message-body">{{ session('success') }}</p>
    </div>
@endif

@if (session()->has('errors'))
<div class="message is-danger">
    <div class="message-header">
        {{ _('Error') }}
    </div>
    <div class="message-body">
        <ul>
        @foreach (session('errors')->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
</div>
@endif

@if (session()->has('error'))
    <div class="message is-danger">
        <div class="message-header">
            {{ _('Error') }}
        </div>
        <p class="message-body">{{ session('error') }}</p>
    </div>
@endif

@if (session()->has('info'))
    <div class="message is-info">
        <div class="message-header">
            {{ _('Info') }}
        </div>
        <p class="message-body">{{ session('info') }}</p>
    </div>
@endif
