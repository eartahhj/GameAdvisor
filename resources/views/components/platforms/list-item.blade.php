<li class="tile is-parent notification item-single platform-single background-5">
    <article class="tile is-child">
        <figure class="image">
            @if ($platform->image and $image)
            <img src="/storage/{{ $platform->image }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}" loading="lazy">
            @else
            <img src="/storage/images/placeholders/platform1.png" alt="" width="800" height="600" loading="lazy">
            @endif
        </figure>
        <div class="tile-content">
            <h2 class="title is-4 platform-title">
                <a href="{{ route('platforms.show', $platform->id) }}">{{ $platform->name }}</a>
            </h2>
            <p class="text platform-text">{{ strip_tags($platform->description) }}</p>
            <p class="buttons">
                @if (!empty($href) and !empty($rel) and !empty($text))
                <a href="{{ $href }}" rel="{{ $rel }}" class="button is-secondary">{{ $text }}</a>
                @endif
                @if (!empty(auth()->user()) and auth()->user()->is_superadmin)
                <a href="{{ route('platforms.edit', $platform->id) }}" class="button is-dark">{{ _('Edit') }}</a>
                @endif
            </p>
        </div>
    </article>
</li>
