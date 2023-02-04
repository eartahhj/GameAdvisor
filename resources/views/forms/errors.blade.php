<div class="message {{ $class }}">
    <div class="message-body">
        <p>{{ $text }}</p>
        <ul>
            @foreach ($errors->all() as $error)                
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
