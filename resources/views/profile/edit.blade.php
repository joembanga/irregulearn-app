<x-app-layout>
    <div class="py-2 bg-app px-4 sm:px-6 lg:px-8 max-w-5xl space-y-12">

        <!-- Header Section -->
        <div class="text-left">
            <h1 class="text-3xl md:text-4xl font-bold text-body">{{ __('Paramètres') }}</h1>
            <p class="text-muted font-medium mt-2">{{ __('Gère tes informations personnelles et personnalise ton expérience.') }}</p>
        </div>

        <!-- Profile Overview -->
        <div class="p-2 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative overflow-hidden">
            @php
                $userId = $user->id;
                $size1 = 24;
                $size2 = 32;
            @endphp
            <div class="text-left flex items-center gap-4">
                <livewire:user-avatar :$userId :$size1 :$size2 />

                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-body capitalize">
                        {{ $user->firstname }} {{ $user->lastname }}
                    </h2>
                    <p class="text-primary font-bold text-sm mt-1">
                        {{ $user->username }} • {{ number_format($user->xp_total) }} XP
                    </p>
                </div>
            </div>

            <button @click="open = !open; $nextTick(() => $dispatch('scroll-to-editor'))"
                class="hidden md:block px-8 py-4 bg-primary text-surface rounded-xl font-bold text-sm transition hover:scale-105 active:scale-95">
                {{ __('Modifier mon avatar') }}
            </button>
        </div>

        <!-- Settings Modules -->
        <div class="grid grid-cols-1 gap-8">
            <!-- Info Section -->
            <div class="card-surface p-6 md:p-8 rounded-xl border border-muted shadow-sm">
                <div class="max-w-3xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Avatar Editor Zone -->
            <div id="avatar-section" class="scroll-mt-24" x-data
                @scroll-to-editor.window="document.getElementById('avatar-section').scrollIntoView({ behavior: 'smooth' })">
                <div class="card-surface rounded-xl p-6 md:p-8 shadow-sm border border-muted">
                    <livewire:avatar-editor />
                </div>
            </div>

            <!-- Security Section -->
            <div class="card-surface p-6 md:p-8 rounded-xl border border-muted shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Danger Zone -->
            {{-- <div class="card-surface p-8 md:p-12 rounded-xl border border-danger/10 bg-danger-5 opacity-80 hover:opacity-100 transition-opacity">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
            <div class="card-surface p-6 md:p-8 rounded-xl border border-muted">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-body">
                                {{ __('Delete Account') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-muted">
                                {{ __('Si vous souhaitez supprimer votre compte ansi que vos données conservées dans l\'application, vous devez nous contacter via le support en présentant la raison.') }}
                            </p>

                            <a href="#" class="mt-6 inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 transition ease-in-out duration-150">
                                {{ __('Contacter le support') }}
                            </a>

                        </header>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>