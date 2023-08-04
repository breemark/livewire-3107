<div>
    <ul>
        @foreach ($articles as $article)
            <li>{{ $article->title }}</li>                
        @endforeach
    </ul>
</div>