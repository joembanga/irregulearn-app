<x-app-layout>
    <div class="py-6 lg:py-12 bg-app">
        <div class="max-w-5xl mx-auto px-6 space-y-12">

            <!-- Header Section -->
            <div class="text-center md:text-left">
                <h1 class="text-4xl font-bold text-body tracking-tight uppercase">Paramètres</h1>
                <p class="text-muted font-medium mt-2">Gère tes informations personnelles et personnalise ton
                    expérience.</p>
            </div>

            <!-- Profile Overview Card -->
            <div
                class="card-surface rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-muted flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
                <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-linear-to-tr from-primary to-purple-600 rounded-full blur opacity-25 group-hover:opacity-40 transition duration-700">
                        </div>
                        @if(!empty($user->avatar_code))
                        @php
                        $options = [];
                        parse_str($user->avatar_code, $options);
                        @endphp
                        <img src="{{ 'https://avataaars.io/?' . http_build_query($options) }}" alt="Avatar"
                            class="relative w-32 h-32 rounded-full border-4 border-surface shadow-2xl object-cover bg-surface">
                        @else
                        <div
                            class="relative w-32 h-32 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-5xl border-4 border-surface shadow-2xl">
                            {{ substr(\Illuminate\Support\Str::upper($user->username), 0, 1) }}
                        </div>
                        @endif
                    </div>

                    <div class="text-center md:text-left">
                        <h2 class="text-3xl font-bold text-body uppercase tracking-tight">{{ $user->firstname }}
                            {{ $user->lastname }}
                        </h2>
                        <p class="text-primary font-bold text-xs tracking-[0.2em] mt-1">{{ $user->username }} •
                            {{ number_format($user->xp_total) }} XP
                        </p>
                    </div>
                </div>

                @if(auth()->id() === $user->id)
                <div x-data="{ open: false }" class="relative z-10">
                    <button @click="open = !open; $nextTick(() => $dispatch('scroll-to-editor'))"
                        class="px-8 py-4 bg-primary text-surface rounded-2xl font-bold text-sm transition hover:scale-105 active:scale-95 shadow-lg shadow-primary/20">
                        🎭 MODIFIER MON LOOK
                    </button>
                </div>
                @endif
            </div>

            <!-- Avatar Editor Section (Conditional) -->
            @if(auth()->id() === $user->id)
            <div id="avatar-section" class="scroll-mt-24" x-data
                @scroll-to-editor.window="document.getElementById('avatar-section').scrollIntoView({ behavior: 'smooth' })">
                <div class="card-surface rounded-[2.5rem] p-8 md:p-12 shadow-xl border border-muted">
                    <div class="mb-10 text-center">
                        <h3 class="text-2xl font-bold text-body uppercase tracking-tighter italic">Personnalisation du
                            Héros</h3>
                        <p class="text-muted text-sm mt-1">Crée un avatar qui te ressemble (ou pas du tout).</p>
                    </div>
                    <livewire:avatar-editor />
                </div>
            </div>
            @endif

            <!-- Settings Modules -->
            <div class="grid grid-cols-1 gap-8">
                <!-- Info Section -->
                <div class="card-surface p-8 md:p-12 rounded-[2.5rem] border border-muted shadow-sm">
                    <div class="max-w-3xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Security Section -->
                <div class="card-surface p-8 md:p-12 rounded-[2.5rem] border border-muted shadow-sm">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div
                    class="card-surface p-8 md:p-12 rounded-[2.5rem] border border-danger/10 bg-danger-5 opacity-80 hover:opacity-100 transition-opacity">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>