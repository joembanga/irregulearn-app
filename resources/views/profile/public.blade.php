@section('og_title', $user->username . " sur IrreguLearn")
@section('og_description', "Viens battre mon record de " . $user->current_streak . " jours de série sur IrreguLearn !")
@section('og_image', route('share.image', ['type' => 'profile', 'identifier' => $user->username]))
<x-app-layout>
    @php
    $isFriend = DB::table('friendships')
        ->where(function($q) use ($user) {
            $q->where('sender_id', auth()->id())
                ->where('recipient_id', $user->id);
        })
        ->where('status', 'accepted')
        ->exists();
    @endphp

    <div class="py-2 bg-app min-h-screen">
        <div class="max-w-5xl mx-auto space-y-8">

            <!-- Hero Profile Section -->
            <div class="p-6 md:p-10 relative overflow-hidden">

                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 md:gap-10">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-linear-to-tr from-primary to-purple-600 rounded-full blur opacity-25 hover:opacity-40 transition duration-700">
                        </div>
                        <div class="relative size-32 md:size-40 bg-surface rounded-full flex items-center justify-center text-4xl text-primary font-bold shadow-2xl border-4 border-surface overflow-hidden">
                            <x-user-avatar :user="$user" />
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left space-y-2">
                        <div>
                            <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider mb-3 animate-pulse">
                                {{ $user->level_name }}
                            </div>
                            <h1 class="text-4xl md:text-5xl mb-2 font-bold text-body tracking-tight">
                                {{ $user->username }}
                            </h1>
                            <p class="text-muted font-medium mt-1">A rejoins la plateforme depuis
                                {{ $user->created_at->format('M Y') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap justify-center md:justify-start gap-3">
                            @if(auth()->id() !== $user->id)
                            <livewire:follow-button :user="$user" />
                            @endif
                            <x-share-button :title="$user->username . ' sur IrreguLearn'"
                                :text="'Viens voir mon profil sur IrreguLearn et apprends les verbes irréguliers avec moi !'"
                                :url="route('profile.public', $user->username)" class="mt-6" />
                            {{-- <button x-data="{ copied: false }"
                                @click="navigator.clipboard.writeText('{{ route('share.image', ['type' => 'stats', 'identifier' => $user->username]) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="inline-flex items-center gap-2 mt-6 px-6 py-2 bg-primary/10 border border-primary/20 text-primary rounded-2xl font-bold text-sm hover:bg-primary/20 transition active:scale-95 shadow-sm">
                                <span x-show="!copied">🏆 Partager mon Trophée</span>
                                <span x-show="copied" x-cloak class="text-success">✅ Lien image copié !</span>
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>

            @if($isFriend)
            <livewire:transfer-points :receiver="$user" />
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-3 gap-3 md:gap-6 lg:gap-8">
                <!-- Streak Card -->
                <div class="card-surface p-8 rounded-3xl border border-muted flex flex-col items-center justify-center text-center group hover:border-orange-400 transition-colors">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🔥</div>
                    <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] mb-1">Série</p>
                    <p class="text-3xl font-bold text-body">{{ $user->current_streak }} jours</p>
                </div>

                <!-- XP Card -->
                <div
                    class="card-surface p-8 rounded-3xl border border-muted flex flex-col items-center justify-center text-center group hover:border-primary transition-colors">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">⚡</div>
                    <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] mb-1">XP Hebdo</p>
                    <p class="text-3xl font-bold text-body">{{ number_format($user->xp_weekly) }}</p>
                </div>

                <!-- Verbs Card -->
                <div
                    class="card-surface p-8 rounded-3xl border border-muted flex flex-col items-center justify-center text-center group hover:border-purple-500 transition-colors">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📖</div>
                    <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] mb-1">verbes appris</p>
                    <p class="text-3xl font-bold text-body">
                        {{ $user->learnedVerbs()->count() }}
                    </p>
                </div>
            </div>

            <!-- Badges Section -->
            <div class="card-surface p-8 md:p-12 rounded-[2.5rem] border border-muted">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-2xl font-bold text-body uppercase tracking-tighter">Collections de Badges</h3>
                    <span class="text-xs font-bold text-muted uppercase tracking-widest">{{ $user->badges->count() }}
                        débloqués</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6">
                    @forelse($user->badges as $badge)
                    <div class="group flex flex-col items-center">
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-primary/20 blur-xl rounded-full scale-0 group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div
                                class="relative w-20 h-20 bg-surface border border-muted rounded-2xl flex items-center justify-center text-3xl shadow-sm group-hover:shadow-xl group-hover:-translate-y-2 transition-all duration-300">
                                {{ $badge->icon }}
                            </div>
                        </div>
                        <span
                            class="mt-4 text-[10px] font-bold text-muted uppercase tracking-widest text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $badge->name }}
                        </span>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center">
                        <div class="text-5xl opacity-20 mb-4">🏆</div>
                        <p class="text-muted font-medium">En attente de ses premiers exploits...</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>