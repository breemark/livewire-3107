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
                        <x-image-input wire:model="image" :image="$image" :existing="$article->image" />
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
                        <x-label for="category_id" :value="__('Category')"/>
                        <div class="flex space-x-2 mt-1">
                            <x-select 
                                id="category_id" 
                                class="block w-full" 
                                wire:model="article.category_id" 
                                :options="$categories"
                                :placeholder="__('Select Category')" />
                                <x-secondary-button
                                    wire:click="$set('showCategoryModal', true)" 
                                    class="!p-2.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                                        </path>
                                    </svg>
                                </x-secondary-button>
                            <x-input-error class="mt-2" for="article.category_id" />
                        </div>

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
    <x-dialog-modal wire:model="showCategoryModal">
		<x-slot name="title">Modal Title</x-slot>
		<x-slot name="content">Category Form</x-slot>

		<x-slot name="footer">
			<x-secondary-button wire:click="$set('showCategoryModal', false)">
                Cancel
            </x-secondary-button>
		</x-slot>
	</x-dialog-modal>
</div>
