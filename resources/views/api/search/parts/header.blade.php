<div
    class='flex items-center justify-between transition-colors duration-250 hover:bg-gray-300 py-2 px-2.5 cursor-pointer' onclick="window.location.href = '{{ route('car.parts.show', [$part->category->model->car->slug, $part->category->model->slug, $part->category->slug, $part->id, $part->modification->id ?? null]) }}'">
    <div class="aspect-square flex items-center justify-center flex-none">
        <img src='{{ asset('images/parts/' . $part->category->model->car->name . '/' . $part->image) }}' alt='{{$part->name}}' class="w-16 h-auto my-auto object-scale-down">
    </div>

    <div class='flex flex-col mx-3 truncate w-full'>
        <span class='text-sm font-semibold truncate' title="{{$part->name}}">{{$part->name}}</span>
        <span class='text-xs text-gray-500'>@lang('parts.fields.code'): {{$part->code}}</span>
    </div>

    <div class="flex items-center gap-3 flex-1 ml-3">
        <span class='text-sm font-semibold my-auto'>{{ money($part->price, 'EUR', true) }}</span>

        <form action="{{ route('cart.add', $part->id) }}" method="POST">
            @csrf

            <button type="submit"
                    class='btn btn-primary btn-sm text-xs font-semibold whitespace-nowrap w-full'>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </button>
        </form>
    </div>
</div>
