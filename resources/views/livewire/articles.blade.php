<div>
    <h1>Article Listing</h1>
    <a href="{{ route('articles.create') }}"> Create </a>
    <label>
        <input type="search" placeholder="Search..." wire:model="search">
    </label>
    
    <ul>
        @foreach ($articles as $article)

            <li>
                <a href="{{ route('articles.show', $article) }}"> {{ $article->title }} </a>
            </li>
                            
        @endforeach
    </ul>
</div>