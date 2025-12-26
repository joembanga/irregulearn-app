<div class="mt-4">
    <label for="username" class="block font-medium text-sm text-gray-700">Pseudo</label>

    <div class="relative mt-1">
        <input wire:model.live.debounce.300ms="username" id="username" type="text" name="username" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-accent focus:border-accent {{ $status === 'valid' ? 'border-success ring-success' : '' }} {{ $status === 'invalid' ? 'border-danger ring-danger' : '' }}">

        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            @if($status === 'valid')
            <span class="text-success text-xl">✓</span>
            @elseif($status === 'invalid')
            <span class="text-danger text-xl">✗</span>
            @endif
        </div>
    </div>

    <p class="mt-2 text-sm {{ $status === 'valid' ? 'text-green-600' : 'text-red-600' }}">
        {{ $message }}
    </p>
</div>