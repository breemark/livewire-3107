<div>
    <h1>{{ __('Create Article') }}</h1>
    <form wire:submit.prevent='save' >
        @csrf
        <label>
            <input wire:model='title' type="text" placeholder="{{ __('Title') }}" >
        </label>
        <label>
            <textarea wire:model='content' placeholder="{{ __('Content') }}"></textarea>
        </label>
        <input type="submit" value="{{ __('Save') }}">
    </form>
</div>
