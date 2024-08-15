<div @class([$class ?? '', 'bg-white dark:bg-zinc-800 shadow-lg rounded-lg', 'p-4'=> !isset($flush) || !$flush,
    ])>
    {{ $slot }}
</div>