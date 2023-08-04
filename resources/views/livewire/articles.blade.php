<div>
    <h1>Article Listing</h1>
    <input type="search" placeholder="Search..." wire:model="search">
    <ul>
        @foreach ($articles as $article)
            <li>{{ $article->title }}</li>                
        @endforeach
    </ul>
</div>