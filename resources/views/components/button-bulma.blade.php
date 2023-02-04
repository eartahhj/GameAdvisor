<button {{ $attributes->merge(['type' => 'button', 'class' => 'button']) }}>
    <a href="{{ $link }}">
        {{ $text }}
    </a>
</button>
