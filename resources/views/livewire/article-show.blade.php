<div>
    <div>{{ $article->id }}</div>
    <div>{{ $article->title }}</div>
    <div>{{ $article->content }}</div>
    <a href="{{ route('home') }}">{{__('Back to Articles')}}</a>
</div>
