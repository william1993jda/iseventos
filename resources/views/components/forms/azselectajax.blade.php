<!-- component -->
@props(['label', 'name', 'parent_id', 'parent_label'])
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
<div class="flex flex-col items-center" x-data="{
    open: false,
    emptyParentId: false,
    items: [],
    loading: false,
    search: '',
    selectedItem: { id: null, name: null },
    get searchResults() {
        if (!this.search) { return this.items }

        return this.items.filter((item) => {
            return item.name.toLowerCase().includes(this.search.toLowerCase());
        });
    }
}" x-init="$watch('open', async (value) => {
    const parentId = document.getElementById('{{ $parent_id }}');
    parentId.addEventListener('change', (event) => {
        console.log('xxxx')
        item = []
        this.selectedItem = { id: null, name: null }
    });

    if (!parentId.value) { return emptyParentId = true }

    emptyParentId = false
    loading = true
    const response = await fetch('{{ route('budgets.getCustomerContacts') }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            customer_id: parentId.value,
            _token: '{{ csrf_token() }}'
        })
    })

    items = await response.json()
    loading = false
})">
    <div class="w-full md:w-1/2 flex flex-col items-center">
        <div class="w-full">
            <div class="flex flex-col items-center relative">
                <div class="w-full">
                    <label for="name" class="form-label">{{ $label }}</label>
                    <div class="h-10 bg-white flex border border-gray-200 rounded @error($name) has-error @enderror">
                        <div class="flex flex-auto flex-wrap"></div>
                        <input class="p-1 px-2 appearance-none outline-none w-full text-gray-800" @click="open = true"
                            @click.away="open = false" x-model.debounce.500ms="search" x-bind:value="selectedItem.name">
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
                <div class="w-full" x-show="emptyParentId">
                    <div class="pristine-error text-danger mt-2">Selecione o campo {{ $parent_label }} primeiro</div>
                </div>
                @error($name)
                    <div class="w-full">
                        <div class="pristine-error text-danger mt-2">{{ $message }}</div>
                    </div>
                @enderror
                <div class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto"
                    x-show="open">
                    <div class="flex flex-col w-full">
                        <template x-if="loading">
                            <div class="flex items-center justify-center m-2">
                                <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
                                    role="status">
                                    <span
                                        class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
                                </div>
                            </div>
                        </template>
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
