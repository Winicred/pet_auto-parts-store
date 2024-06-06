<div class="relative w-1/2 shrink">
    <div class="gap-2 flex w-full">
        <input type="text" id="search" name="search"
               class="input input-primary input-sm w-full"
               placeholder="{{ __('header.input.placeholder', ['count' => \App\Models\Part::all()->count()]) }}"
               autocomplete="off"
        >
        <a id="submit" href="{{ route('search.index') }}" class="btn btn-sm btn-primary">{{ __('header.input.button') }}</a>
    </div>

    <div class="absolute z-[2] bg-white rounded mt-5 py-2 w-full top-full left-0 hidden flex-col shadow-xl"
         id="searchResults">
    </div>
</div>