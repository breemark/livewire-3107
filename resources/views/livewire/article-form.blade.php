<div>
    <h1>{{ __('Create Article') }}</h1>
    <form wire:submit.prevent='save' >
        @csrf
        <label>
            <input wire:model='title' type="text" placeholder="{{ __('Title') }}" >
            @error('title')
                <div>{{ $message }}</div>
            @enderror
        </label>
        <label>
            <textarea wire:model='content' placeholder="{{ __('Content') }}"></textarea>
            @error('content')
                <div>{{ $message }}</div>
            @enderror
        </label>
        <input type="submit" value="{{ __('Save') }}">
    </form>
</div>
