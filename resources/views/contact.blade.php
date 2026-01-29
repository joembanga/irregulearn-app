@section('title', __('Contacter le support'))
@section('description', __('Contacter le support IrreguLearn'))
@section('keywords', '...')
@section('og_title', __('Contacter le support'))
@section('og_description', __('Contacter le support IrreguLearn'))
<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-6">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">{{ __('Contact') }}</h1>
            <p class="text-gray-700 dark:text-gray-400 mb-6">{{ __('Pour toute question, partenariat ou support, écrivez-nous à') }} <strong>hello@irregulearn.example</strong> {{ __('ou utilisez le formulaire ci-dessous.') }}</p>

            <form action="/contact-submit" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Nom') }}</label>
                    <input name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                    <input name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Message') }}</label>
                    <textarea name="message" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                </div>
                <div>
                    <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg font-bold">{{ __('Envoyer') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
