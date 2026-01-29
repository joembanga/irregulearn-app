<div class="size-{{ $size1 }} {{ !($size2 === null) ? 'md:size-' . $size2 : '' }} rounded-full bg-primary/10 flex items-center justify-center text-muted font-black truncate">
    @if($hasAvatar)
        <img src="{{ $url }}" alt="{{ $username }}'s avatar" class="w-full h-full object-cover z-10">
    @else
        {{ substr($username, 0, 1) }}
    @endif
</div>
