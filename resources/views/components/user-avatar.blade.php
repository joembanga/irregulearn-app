@props(['user'])

@if(!empty($user->avatar_code))
<img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->username }}" class="w-full h-full object-cover">
@else
{{ substr($user->username, 0, 1) }}
@endif