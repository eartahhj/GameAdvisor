@php
$linkAttributes = $listItemAttributes = [];

if (!empty($route)) {
    if ($route == url()->current() or strpos(request()->route()->getName(), $routeName) !== false) {
        $listItemAttributes['class'] = 'selected';
    }

    $linkAttributes['href'] = $route;
    $linkAttributes['class'] = 'navbar-item';

}
@endphp

<li {{ $attributes->merge($listItemAttributes) }}>
    <a {{ $attributes->merge($linkAttributes) }}>
        {{ $text }}
    </a>
</li>
