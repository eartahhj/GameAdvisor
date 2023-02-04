<li class="publisher-single">
    <article class="box p-0">
        <header>
            <div class="grid grid-align-center">
                <div class="grid-col">
                    <?php /*
                    @if ($publisher->logo and $logo)
                        <figure>
                            <img src="/storage/{{ $publisher->logo }}" alt="" width="{{ $logo->width() }}" height="{{ $logo->height() }}" loading="lazy">
                        </figure>
                    @endif
                    */?>
                    <p class="publisher-name">
                        <a href="{{ route('publishers.show', $publisher->id) }}">{{ $publisher->name }}</a>
                    </p>
                </div>
            </div>
        </header>
        <div class="publisher-description">
            <p class="text">{{ $publisher->description }}</p>
            @if (!empty($href) and !empty($rel) and !empty($text))
                <a href="{{ $href }}" rel="{{ $rel }}">{{ $text }}</a>
            @endif
        </div>
    </article>
</li>
