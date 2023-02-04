<li class="developer-single">
    <article class="box p-0">
        <header>
            <div class="grid grid-align-center">
                <div class="grid-col">
                    <?php
                    /*
                    @if ($developer->logo and $logo)
                        <figure>
                            <img src="/storage/{{ $developer->logo }}" alt="" width="{{ $logo->width() }}" height="{{ $logo->height() }}" loading="lazy">
                        </figure>
                    @endif
                    */
                    ?>
                    <p class="developer-name">
                        <a href="{{ route('developers.show', $developer->id) }}">{{ $developer->name }}</a>
                    </p>
                </div>
            </div>
        </header>
        <div class="developer-description">
            <p class="text">{{ $developer->description }}</p>
            @if (!empty($href) and !empty($rel) and !empty($text))
                <a href="{{ $href }}" rel="{{ $rel }}">{{ $text }}</a>
            @endif
        </div>
    </article>
</li>
