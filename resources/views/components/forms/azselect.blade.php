<!-- component -->
@props(['label', 'name', 'items', 'selected'])
<style>
    .top-100 {
        top: 100%
    }

    .bottom-100 {
        bottom: 100%
    }

    .max-h-select {
        max-height: 300px;
    }
</style>
<div class="flex flex-col items-center"
    x-data='{
    open: false,
    items: @json($items),
    selected: @json($selected),
    search: "",
    selectedItem: { id: "2", name: "wdwd" },
    get searchResults() {
        if (!this.search) { return this.items }

        return this.items.filter((item) => {
            return item.name.toLowerCase().includes(this.search.toLowerCase());
        });
    }
}'>
    <div class="w-full md:w-1/2 flex flex-col items-center">
        <div class="w-full">
            <div class="flex flex-col items-center relative">
                <div class="w-full">
                    <label for="name" class="form-label">{{ $label }}</label>
                    <div class="h-10 bg-white flex border border-gray-200 rounded @error($name) has-error @enderror"
                        @click="open = true" @click.away="open = false">
                        <div class="flex flex-auto flex-wrap"></div>
                        <input class="p-1 px-2 appearance-none outline-none w-full text-gray-800"
                            x-model.debounce.500ms="search" x-bind:value="selectedItem.name">
                        <input type="hidden" name="{{ $name }}" id="{{ $name }}"
                            x-bind:value="selectedItem.id">
                        <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200">
                            <button type="button"
                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-chevron-up w-4 h-4">
                                    <polyline points="18 15 12 9 6 15"></polyline>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @error($name)
                    <div class="w-full">
                        <div class="pristine-error text-danger mt-2">{{ $message }}</div>
                    </div>
                @enderror
                <div class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto"
                    x-show="open">
                    <div class="flex flex-col w-full">
                        <template x-for="item in searchResults">
                            <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-red-100">
                                <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:bg-red-100"
                                    @click="selectedItem = item">
                                    <div class="w-full items-center flex">
                                        <div class="mt-1" x-text="item.name"></div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
