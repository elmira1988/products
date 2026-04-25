<script setup>
import { ref, watch } from 'vue';
import { router, Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object
});

// Состояние для фильтра
const selectedCategory = ref(props.filters.category_id || '');

// Следим за изменением категории и делаем запрос через Inertia
watch(selectedCategory, (value) => {
    router.get('/', { category_id: value }, {
        preserveState: true,
        replace: true
    });
});
</script>

<template>
    <Head title="Каталог товаров" />

    <!-- Общий фон: мягкий бежевый -->
    <div class="min-h-screen bg-[#F7F5F2] py-12">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Заголовок и фильтр на одной линии -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12 gap-6">
                <div>
                    <h1 class="text-3xl font-semibold text-stone-800 tracking-tight">Каталог товаров</h1>
                    <p class="text-stone-400 text-sm mt-1 font-medium">Найдено позиций: {{ products.total }}</p>
                </div>

                <div class="w-full md:w-64 text-left">
                    <label class="flex items-center text-[10px] uppercase tracking-[0.2em] font-bold text-stone-400 mb-2 ml-1">
                        <svg xmlns="http://w3.org" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55a.75.75 0 01-1.219-.585V11.75a2.25 2.25 0 00-.659-1.59l-4.682-4.683a2.25 2.25 0 01-.659-1.59V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                        </svg>
                        Категории
                    </label>
                    <select
                        v-model="selectedCategory"
                        class="block w-full border-stone-200 focus:ring-stone-400 focus:border-stone-400 text-sm rounded-md shadow-sm bg-white text-stone-700 py-2.5 transition-all"
                    >
                        <option value="">Все позиции</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Список товаров -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="product in products.data" :key="product.id" class="bg-white group overflow-hidden shadow-sm hover:shadow-md transition-all duration-500 rounded-lg border border-stone-200/60 p-6 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-lg font-semibold text-stone-800 group-hover:text-stone-600 transition-colors">{{ product.name }}</h2>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] uppercase tracking-wider font-bold bg-stone-100 text-stone-500 border border-stone-200">
                            {{ product.category.name }}
                        </span>
                    </div>

                    <!-- Описание -->
                    <p class="text-stone-500 text-sm line-clamp-2 mb-8 font-normal leading-relaxed">
                        {{ product.description }}
                    </p>

                    <div class="mt-auto flex items-center justify-between border-t border-stone-50 pt-5">
                        <span class="text-xl font-medium text-stone-900">{{ product.price }} ₽</span>
                        <Link
                            :href="`/product/${product.id}`"
                            class="text-stone-400 hover:text-stone-800 text-xs uppercase tracking-widest font-bold underline-offset-8 transition-all"
                        >
                            Подробнее ->
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Пагинация -->
            <div class="mt-16 flex justify-center space-x-1">
                <Component
                    :is="link.url ? Link : 'span'"
                    v-for="link in products.links"
                    :key="link.label"
                    :href="link.url"
                    v-html="link.label"
                    class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest border transition-all rounded"
                    :class="{
                        'bg-stone-800 text-white border-stone-800 shadow-sm': link.active,
                        'text-stone-300 border-transparent pointer-events-none': !link.url,
                        'text-stone-500 border-stone-200 hover:bg-white hover:border-stone-400': link.url && !link.active
                    }"
                />
            </div>
        </div>
    </div>
</template>
