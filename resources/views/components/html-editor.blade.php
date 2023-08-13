<div x-data="{ value: @entangle($attributes->wire('model')).defer }"
	x-on:trix-change="value = $event.target.value"
	@trix-file-accept.prevent
>
	<div wire:ignore >
		<trix-editor 
			:value="value" 
			{!! 
				$attributes->whereDoesntStartWith('wire:model')->merge([
					'class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']) 
			!!}>
		</trix-editor>
	</div>
</div>



<style>
trix-toolbar [data-trix-button-group="file-tools"],
trix-toolbar [data-trix-button-group="history-tools"] {
    display: none;
}
</style>