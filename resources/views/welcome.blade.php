<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Master English irregular verbs through gamified learning. Join thousands of students, earn XP, maintain streaks, and unlock achievements.">
    <meta property="og:title" content="IrreguLearn - Master English Irregular Verbs">
    <meta property="og:description"
        content="Transform verb learning into an engaging game with friends. XP points, streaks, leaderboards, and badges await.">
    <meta property="og:type" content="website">
    <title>IrreguLearn - Master English Irregular Verbs Through Gamified Learning</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dark .glass-card {
            background: rgba(32, 32, 64, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="antialiased font-sans text-body scroll-smooth bg-linear-to-b from-surface via-surface to-app/5 selection:bg-primary/20">
    <!-- Navigation -->
    <header class="fixed left-0 right-0 top-0 z-50 border-b border-primary/10 backdrop-blur-xl bg-surface/80">
        <nav class="flex items-center justify-between px-6 sm:px-12 py-5 max-w-8xl mx-auto">
            <a href="/" wire:navigate class="flex items-center gap-3 group">
                <div class="bg-primary text-surface p-2.5 rounded-xl font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                    IL
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-xl tracking-tight text-body">IrreguLearn</span>
                    <span class="text-[10px] uppercase tracking-widest text-primary font-bold">Master English</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-10">
                <a href="#sets" class="text-sm font-semibold hover:text-primary transition-colors">Study Sets</a>
                <a href="#features" class="text-sm font-semibold hover:text-primary transition-colors">Features</a>
                <a href="#testimonials" class="text-sm font-semibold hover:text-primary transition-colors">Testimonials</a>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" wire:navigate class="font-bold text-sm text-primary hover:underline">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="hidden sm:inline-block font-bold text-sm text-body hover:text-primary transition-colors">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" wire:navigate class="bg-primary hover:bg-primary/90 text-surface px-6 py-2.5 rounded-full font-bold text-sm transition-all hover:shadow-lg hover:shadow-primary/30 active:scale-95">
                            Get Started
                        </a>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main class="relative overflow-hidden">
        <!-- Background Blobs -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full -z-10">
            <div class="absolute top-[10%] -left-[10%] w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute top-[20%] -right-[10%] w-[400px] h-[400px] bg-accent/10 rounded-full blur-[100px] animation-delay-2000"></div>
        </div>

        <!-- Hero Section -->
        <section class="pt-32 pb-20 sm:pt-48 sm:pb-32 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-bold mb-8 animate-float">
                    <span>✨</span> Join 2,500+ students mastering verbs
                </div>
                
                <h1 class="text-5xl sm:text-7xl font-black text-body tracking-tight leading-[1.1] mb-8">
                    The smartest way to learn <br/>
                    <span class="text-primary italic">English verbs.</span>
                </h1>
                
                <p class="text-xl text-muted font-medium mb-12 max-w-2xl mx-auto leading-relaxed">
                    Quizlet-style study sets, gamified exercises, and real-time streaks. Everything you need to master irregular verbs in record time.
                </p>

                <!-- Prominent Search Bar (Inspired by Quizlet) -->
                <div class="relative max-w-2xl mx-auto group">
                    <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-muted group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Search for a verb... (e.g. 'Go', 'Speak', 'Write')" 
                           class="w-full pl-16 pr-6 py-6 bg-surface border-2 border-primary/10 rounded-2xl text-lg font-medium focus:border-primary focus:ring-0 shadow-xl shadow-primary/5 transition-all placeholder:text-muted/50">
                    <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-primary text-surface px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:shadow-primary/40 hover:-translate-y-0.5 active:scale-95 transition-all">
                        Find Word
                    </button>
                </div>
            </div>
        </section>

        <!-- Ready to Study? Section (Study Sets) -->
        <section id="sets" class="py-20 px-6 bg-surface/50">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-black text-body mb-2 uppercase tracking-tighter italic">Ready to study?</h2>
                        <p class="text-muted font-medium">Choose a level and start mastering English today.</p>
                    </div>
                    <a href="{{ route('register') }}" class="text-sm font-bold text-primary flex items-center gap-2 hover:underline">
                        View all sets <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                    $sets = [
                        ['title' => 'The Must-Knows', 'count' => '25 Verbs', 'icon' => '🔥', 'color' => 'primary', 'desc' => 'The essential irregular verbs every beginner needs.'],
                        ['title' => 'Past Participle Fun', 'count' => '40 Verbs', 'icon' => '🎯', 'color' => 'accent', 'desc' => 'Master complex forms with context-based exercises.'],
                        ['title' => 'Expert Verbs', 'count' => '60 Verbs', 'icon' => '🏆', 'color' => 'warning', 'desc' => 'Rare and challenging verbs for advanced learners.'],
                    ];
                    @endphp

                    @foreach($sets as $set)
                    <div class="glass-card group p-8 rounded-3xl] transition-all hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/10">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-4xl group-hover:scale-110 transition-transform">{{ $set['icon'] }}</span>
                            <span class="text-xs font-black uppercase tracking-widest text-[#{{ $set['color'] == 'primary' ? '3f25e7' : ($set['color'] == 'accent' ? '3b82f6' : 'f59e0b') }}]">{{ $set['count'] }}</span>
                        </div>
                        <h3 class="text-2xl font-black text-body mb-3">{{ $set['title'] }}</h3>
                        <p class="text-muted text-sm font-medium mb-8 leading-relaxed">
                            {{ $set['desc'] }}
                        </p>
                        <a href="{{ route('register') }}" class="block w-full text-center py-4 rounded-2xl bg-muted/20 font-bold text-body group-hover:bg-primary group-hover:text-surface transition-all">
                            Start Study
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-32 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div>
                        <span class="text-xs font-black uppercase tracking-[0.2em] text-primary mb-6 block italic">Study Smarter</span>
                        <h2 class="text-4xl sm:text-5xl font-black text-body leading-tight mb-8">
                            Learning that feels <br/>
                            <span class="text-primary italic">effortless.</span>
                        </h2>
                        
                        <div class="space-y-10">
                            <div class="flex gap-6">
                                <div class="shrink-0 w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-xl">🧠</div>
                                <div>
                                    <h4 class="text-lg font-bold text-body mb-2">Spaced Repetition</h4>
                                    <p class="text-muted text-sm leading-relaxed">Our algorithm ensures you review verbs exactly when you're about to forget them.</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="shrink-0 w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-xl">🎮</div>
                                <div>
                                    <h4 class="text-lg font-bold text-body mb-2">Gamified Experience</h4>
                                    <p class="text-muted text-sm leading-relaxed">Earn XP, collect badges, and maintain your streak. It's more than learning, it's a game.</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="shrink-0 w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center text-xl">👥</div>
                                <div>
                                    <h4 class="text-lg font-bold text-body mb-2">Social Learning</h4>
                                    <p class="text-muted text-sm leading-relaxed">Compete with friends on leaderboards and share your custom verb examples.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <!-- Preview Card -->
                        <div class="bg-surface rounded-3xl p-8 shadow-2xl border border-primary/10 animate-float">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-linear-to-br from-primary to-accent"></div>
                                    <div>
                                        <p class="text-xs font-bold text-body">New Challenge</p>
                                        <p class="text-[10px] text-muted">Past Simple Test</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-success/10 text-success text-[10px] font-black rounded-full">+50 XP</span>
                            </div>
                            <div class="text-center py-10">
                                <p class="text-muted text-sm mb-2 uppercase tracking-widest font-bold">Infinitive</p>
                                <h3 class="text-5xl font-black text-body mb-10">To Choose</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-surface border-2 border-primary/20 p-4 rounded-2xl text-center">
                                        <p class="text-[10px] text-muted uppercase font-bold mb-1">Past Simple</p>
                                        <p class="text-xl font-black text-primary">Chose</p>
                                    </div>
                                    <div class="bg-surface border-2 border-primary/20 p-4 rounded-2xl text-center">
                                        <p class="text-[10px] text-muted uppercase font-bold mb-1">Participle</p>
                                        <p class="text-xl font-black text-primary">Chosen</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 p-4 bg-primary/5 rounded-2xl flex items-center justify-between">
                                <span class="text-xs font-bold text-primary">Mastery Level: 85%</span>
                                <div class="w-24 h-1.5 bg-primary/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-[85%]"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Decor -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-accent/20 rounded-full blur-3xl -z-10 animate-pulse"></div>
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl -z-10 animation-delay-4000"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-primary rounded-[3rem] mx-6">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid md:grid-cols-4 gap-12 text-center text-surface">
                    <div>
                        <p class="text-4xl font-black mb-1">2,500+</p>
                        <p class="text-sm font-bold opacity-70">Active Students</p>
                    </div>
                    <div>
                        <p class="text-4xl font-black mb-1">1,000+</p>
                        <p class="text-sm font-bold opacity-70">Verbs Mastered</p>
                    </div>
                    <div>
                        <p class="text-4xl font-black mb-1">500K+</p>
                        <p class="text-sm font-bold opacity-70">Exercises Daily</p>
                    </div>
                    <div>
                        <p class="text-4xl font-black mb-1">4.9/5</p>
                        <p class="text-sm font-bold opacity-70">User Rating</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-40 px-6 text-center">
            <h2 class="text-5xl sm:text-7xl font-black text-body mb-10 tracking-tight italic">
                Ready to become <br/>
                <span class="text-primary tracking-tighter uppercase not-italic">Fluent?</span>
            </h2>
            <p class="text-xl text-muted font-medium mb-12 max-w-2xl mx-auto">
                Join thousands of students and start your journey today. It's free, fun, and effective.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}" wire:navigate class="bg-primary hover:bg-primary/90 text-surface px-12 py-6 rounded-3xl font-black text-xl shadow-2xl shadow-primary/30 hover:-translate-y-1 active:scale-95 transition-all">
                    Register for Free
                </a>
                <a href="{{ route('login') }}" wire:navigate class="font-black text-body hover:text-primary transition-colors flex items-center gap-2 group">
                    Log In to account <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-primary/10 pt-20 pb-10 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-20">
                <div class="col-span-2 lg:col-span-1">
                    <a href="/" wire:navigate class="flex items-center gap-3 w-fit mb-6">
                        <div class="bg-primary text-surface p-2 rounded-lg font-bold text-sm">IL</div>
                        <span class="font-bold text-lg text-body">IrreguLearn</span>
                    </a>
                    <p class="text-sm text-muted font-medium leading-relaxed">
                        Mastering English irregular verbs through gamification and community.
                    </p>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-widest text-primary mb-6 italic">Product</h5>
                    <ul class="space-y-4 text-sm font-bold text-body">
                        <li><a href="#sets" class="hover:text-primary transition-colors">Study Sets</a></li>
                        <li><a href="#features" class="hover:text-primary transition-colors">How it works</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-primary transition-colors">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-widest text-primary mb-6 italic">Support</h5>
                    <ul class="space-y-4 text-sm font-bold text-body">
                        <li><a href="{{ route('about') }}" class="hover:text-primary transition-colors">Help Center</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-primary transition-colors">Contact Us</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-primary transition-colors">Privacy</a></li>
                    </ul>
                </div>
                <div>
                  <h5 class="font-black text-xs uppercase tracking-widest text-primary mb-6 italic">Social</h5>
                  <div class="flex gap-4">
                      <a href="#" class="w-10 h-10 bg-muted/20 rounded-xl flex items-center justify-center hover:bg-primary hover:text-surface transition-all">𝕏</a>
                      <a href="#" class="w-10 h-10 bg-muted/20 rounded-xl flex items-center justify-center hover:bg-primary hover:text-surface transition-all">📸</a>
                      <a href="#" class="w-10 h-10 bg-muted/20 rounded-xl flex items-center justify-center hover:bg-primary hover:text-surface transition-all">📺</a>
                  </div>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row items-center justify-between pt-10 border-t border-muted/30">
                <p class="text-xs font-bold text-muted">© {{ date('Y') }} IrreguLearn. Made with ❤️ for English learners.</p>
                <div class="flex gap-6 mt-6 md:mt-0">
                    <a href="#" class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">Terms</a>
                    <a href="#" class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">Privacy</a>
                    <a href="#" class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>