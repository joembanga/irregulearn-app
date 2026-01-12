<x-mail::message>
# Bienvenue {{ $user->firstname }} !

C'est un plaisir de t'accueillir sur **IrreguLearn**. Prêt à maîtriser tous les verbes irréguliers ?

<x-mail::button :url="route('dashboard')">
Accéder à mon Dashboard
</x-mail::button>

Bonne chance dans ton apprentissage !

L'équipe IrreguLearn
</x-mail::message>
