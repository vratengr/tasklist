@props(['dragicon' => null, 'item' => null, 'editicon' => null])

<li {{ $attributes->merge(['class' => 'list-none odd:bg-gray-800 odd:text-white odd:stroke-white even:bg-white text-gray-800 even:stroke-black p-2 flex justify-between group']) }}>
    <span class="left flex space-x-1 items-center">
        {{ $dragicon }}
        <span class="list-item">{{ $item }}</span>
    </span>
    <span class="right flex space-x-1">
        <span title="Edit" class="group-odd:hover:bg-white group-odd:hover:stroke-black group-even:hover:bg-black group-even:hover:stroke-white rounded">{{ $editicon }}</span>
        <span title="Delete" class="group-odd:hover:bg-white group-odd:hover:stroke-black group-even:hover:bg-black group-even:hover:stroke-white rounded"><x-svg.delete class="w-5 h-5 cursor-pointer delete"></x-svg.delete></span>
    </span>
</li>