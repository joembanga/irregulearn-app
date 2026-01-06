<h1>Hello {{ $user->firstname }} ! 🚀</h1>
<p>Voici tes 5 verbes à maîtriser aujourd'hui pour garder ta série de <strong>{{ $user->current_streak }} jours</strong>
    :</p>

<ul>
    @foreach($verbs as $verb)
    @php $verbTranslation = $verb->translations()->where('lang', app()->getLocale())->first(); @endphp
    <li><strong>{{ $verb->infinitive }}</strong> ({{ app()->getLocale() !== "en" ? $verbTranslation->translation : '' }}) : {{ $verb->past_simple }},
        {{ $verb->past_participle }}
    </li>
    @endforeach
</ul>

<a href="{{ route('learn') }}"
    style="background: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;">
    Commencer l'entraînement
</a>