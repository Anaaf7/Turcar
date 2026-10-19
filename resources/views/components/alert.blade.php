<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 space-y-3">
    @if (session('sucesso'))
        <div x-data="{ show: true }" x-show="show" x-transition
             class="flex items-center justify-between gap-4 px-4 py-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-700 flex items-center justify-center shrink-0">
                    <x-icon name="check-circle-2" class="w-5 h-5" />
                </div>
                <div>
                    <span class="font-display font-bold text-sm">Sucesso:</span>
                    <span class="text-sm ml-1">{{ session('sucesso') }}</span>
                </div>
            </div>
            <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-950 p-1 cursor-pointer">
                <x-icon name="x" class="w-4 h-4" />
            </button>
        </div>
    @endif

    @if (session('erro'))
        <div x-data="{ show: true }" x-show="show" x-transition
             class="flex items-center justify-between gap-4 px-4 py-3.5 rounded-xl bg-fire-red-50 border border-fire-red-200 text-fire-red-900 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-fire-red/15 text-fire-red flex items-center justify-center shrink-0">
                    <x-icon name="alert-triangle" class="w-5 h-5" />
                </div>
                <div>
                    <span class="font-display font-bold text-sm">Erro:</span>
                    <span class="text-sm ml-1">{{ session('erro') }}</span>
                </div>
            </div>
            <button type="button" @click="show = false" class="text-fire-red hover:text-fire-red-950 p-1 cursor-pointer">
                <x-icon name="x" class="w-4 h-4" />
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-transition
             class="flex items-start justify-between gap-4 px-4 py-4 rounded-xl bg-fire-red-50 border border-fire-red-200 text-fire-red-900 shadow-xs">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-fire-red/15 text-fire-red flex items-center justify-center shrink-0 mt-0.5">
                    <x-icon name="alert-octagon" class="w-5 h-5" />
                </div>
                <div>
                    <p class="font-display font-bold text-sm">Verifique os campos abaixo:</p>
                    <ul class="mt-1.5 text-xs space-y-1 list-disc list-inside text-fire-red-800">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" @click="show = false" class="text-fire-red hover:text-fire-red-950 p-1 cursor-pointer">
                <x-icon name="x" class="w-4 h-4" />
            </button>
        </div>
    @endif
</div>
