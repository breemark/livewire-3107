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
                    <div class="col-span-6 sm:col-span-4 relative">
						@if($image)
							<x-danger-button wire:click="$set('image')" class="absolute bottom-2 right-2">{{ __('Change Image') }}</x-danger-button>
							<img src="{{ $image->temporaryUrl() }}" class="border-2 rounded" alt="">
						@elseif($article->image)
							<x-label for="image" :value="__('Change Image')" class="absolute bottom-2 right-2 cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"/>
							<img src="{{ Storage::disk('public')->url($article->image) }}" class="border-2 rounded" alt="">
						@else
							<div class="h-32 bg-gray-50 border-2 border-dashed rounded flex items-center justify-center">
								<x-label for="image" :value="__('Select Image')" class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"/>
							</div>
						@endif
						<x-input wire:model="image" id="image" class="hidden" type="file" />
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
