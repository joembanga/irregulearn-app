<div class="mt-4">
    <label for="username" class="block font-medium text-sm text-body">Pseudo</label>

    <div class="relative mt-1">
        <input wire:model.live.debounce.200ms="username" id="username" type="text" name="username" required
            class="block w-full border-muted rounded-md shadow-sm focus:ring-primary focus:border-primary {{ $status === 'valid' ? 'border-success ring-success' : '' }} {{ $status === 'invalid' ? 'border-danger ring-danger' : '' }}">
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            @if(str_len($username) > 0 && $status === 'neutral')
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            @elseif($status === 'valid')
            <span class="text-success text-xl">✓</span>
            @elseif($status === 'invalid')
            <span class="text-danger text-xl">✗</span>
            @endif
        </div>
    </div>

    <p class="mt-2 text-sm {{ $status === 'valid' ? 'text-success' : 'text-danger' }}">
        {{ $message }}
    </p>
</div>