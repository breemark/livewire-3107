<div>
    <h1>{{ __('Create Article') }}</h1>
    <form wire:submit.prevent="save" >
        @csrf
        <label>
            <input wire:model="article.title" type="text" placeholder="{{ __('Title') }}" >
            @error('article.title')
                <div>{{ $message }}</div>
            @enderror
        </label>
        <label>
            <textarea wire:model="article.content" placeholder="{{ __('Content') }}"></textarea>
            @error('article.content')
                <div>{{ $message }}</div>
            @enderror
        </label>
        <input type="submit" value="{{ __('Save') }}">
    </form>
</div>
