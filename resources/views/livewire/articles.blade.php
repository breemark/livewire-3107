<div>
    <h1>Article Listing</h1>
    <a href="{{ route('articles.create') }}"> Create </a>
    <label>
        <input type="search" placeholder="Search..." wire:model="search">
    </label>
    
    <ul>
        @foreach ($articles as $article)
            <li>{{ $article->title }}</li>                
        @endforeach
    </ul>
</div>