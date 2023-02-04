<ul {{ $attributes->merge(['class' => 'languages-list']) }}>
    @foreach (\LaravelLocalization::getSupportedLocales() as $langCode => $lang)
        <li><a rel="alternate" hreflang="{{ $langCode }}" {!! ($attributes->get('class') == 'dropdown-content' ? ' class="dropdown-item"' : '') !!} href="/{{ $langCode }}?lang={{ $langCode }}">{{ $lang['native'] }}</a></li>
    @endforeach
</ul>
