@section('title', __('À propos d\'IrreguLearn'))
@section('description', __('En savoir plus sur IrreguLearn'))
@section('keywords', '...')
@section('og_title', __('À propos d\'IrreguLearn'))
@section('og_description', __('En savoir plus sur IrreguLearn'))
@php
$layout = auth()->check() ? 'app-layout' : 'guest-layout';
@endphp

<x-dynamic-component :component="$layout">
    <div class="{{ auth()->check() ? 'py-8' : 'py-4' }} lg:py-6">
        <div class="max-w-4xl mx-auto px-2 lg:px-6">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">{{ __('À propos d\'IrreguLearn') }}</h1>
            <p class="text-gray-700 dark:text-gray-400 mb-6">
                {{ __('IrreguLearn aide les étudiants à maîtriser les verbes irréguliers en proposant des mini-sessions quotidiennes, un système d\'XP, et des challenges entre amis. Notre objectif est de rendre l\'apprentissage répétitif plus engageant et accessible.') }}
            </p>

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-6">{{ __('Notre mission') }}</h2>
            <p class="text-gray-700 dark:text-gray-400">
                {{ __('Rendre l\'anglais accessible via des micro-sessions, de la gamification et un suivi simple. Nous construisons pour les étudiants en RDC et la francophonie.') }}
            </p>

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-6">{{ __('Fonctionnalités') }}</h2>
            <ul class="list-disc pl-5 text-gray-700 dark:text-gray-400">
                <li>{{ __('Sélection quotidienne de verbes') }}</li>
                <li>{{ __('Sessions guidées et quiz') }}</li>
                <li>{{ __('Système d\'XP, badges et classements') }}</li>
                <li>{{ __('Personnalisation d\'avatar et profils publics') }}</li>
            </ul>
        </div>
    </div>
</x-dynamic-component>
