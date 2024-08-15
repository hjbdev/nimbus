<a @class(["flex items-center gap-3 py-2 px-2 rounded transition",
"hover:bg-zinc-100 dark:hover:bg-zinc-800"=> !isset($active) || !$active,
"bg-purple-600/5 font-semibold text-purple-600" => isset($active) && $active]) href="{{ $href }}">
    {{ $slot }}
    {{ $text }}
</a>