<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Article') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-form-section submit="save">
                <x-slot name="title">
                    {{ __('New Article') }}
                </x-slot>
                <x-slot name="description">
                    {{ __('Some Description') }}
                </x-slot>
                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="image" :value="__('Image')"/>
                        <x-input id="image" class="mt-1 block w-full" wire:model="image" type="file"/>
                        <x-input-error class="mt-2" for="image" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="title" :value="__('Title')"/>
                        <x-input id="title" class="mt-1 block w-full" wire:model="article.title" type="text"/>
                        <x-input-error class="mt-2" for="article.title" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="slug" :value="__('Slug')"/>
                        <x-input id="slug" class="mt-1 block w-full" wire:model="article.slug" type="text"/>
                        <x-input-error class="mt-2" for="article.slug" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="content" :value="__('Content')"/>
                        <x-html-editor wire:model="article.content" id="content" class="mt-1 block w-full" ></x-html-editor>
                        <x-input-error for="article.content" class="mt-2"/>
                    </div>
                    <x-slot name="actions">
                        <x-button>
                            {{ __('Save') }}
                        </x-button>
                    </x-slot>
                </x-slot>
            </x-form-section>
        </div>
    </div>
</div>
