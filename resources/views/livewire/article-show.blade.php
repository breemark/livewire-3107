<div>
    <div>{{ $article->id }}</div>
    <div>{{ $article->title }}</div>
    <div>{{ $article->content }}</div>
    <a href="{{ route('articles.index') }}">{{__('Back to Articles')}}</a>
</div>
