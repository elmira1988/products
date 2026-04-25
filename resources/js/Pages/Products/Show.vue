<script setup>
import { Link, Head } from '@inertiajs/vue3';

defineProps({
    product: Object
});
</script>

<template>
    <Head :title="product.name" />

    <div class="min-h-screen bg-[#F7F5F2] py-12">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Кнопка Назад -->
            <Link
                href="/"
                class="text-stone-400 hover:text-stone-800 text-xs uppercase tracking-widest font-bold underline underline-offset-8 transition-all inline-flex items-center mb-10"
            >
                ← Назад к списку
            </Link>

            <div class="bg-white shadow-sm rounded-lg border border-stone-200/60 overflow-hidden">
                <!-- Шапка карточки -->
                <div class="px-8 py-8 border-b border-stone-100 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <span class="text-[10px] uppercase tracking-wider font-bold text-stone-400">
                            {{ product.category.name }}
                        </span>
                        <h1 class="text-3xl font-semibold text-stone-800 mt-1">{{ product.name }}</h1>
                    </div>
                    <div class="text-3xl font-medium text-stone-900">
                        {{ product.price }} ₽
                    </div>
                </div>

                <!-- Контент -->
                <div class="px-8 py-8">
                    <dl class="space-y-8">
                        <div>
                            <dt class="text-[10px] uppercase tracking-[0.2em] font-bold text-stone-400 mb-3">Описание</dt>
                            <dd class="text-stone-600 leading-relaxed font-normal">
                                {{ product.description }}
                            </dd>
                        </div>

                        <div class="pt-6 border-t border-stone-50 flex justify-between items-center">
                            <div>
                                <dt class="text-[10px] uppercase tracking-[0.2em] font-bold text-stone-400">Артикул</dt>
                                <dd class="text-stone-900 text-sm font-medium">#{{ product.id + 1000 }}</dd>
                            </div>
                            <div class="text-right">
                                <dt class="text-[10px] uppercase tracking-[0.2em] font-bold text-stone-400">Добавлено</dt>
                                <dd class="text-stone-900 text-sm font-medium">
                                    {{ new Date(product.created_at).toLocaleDateString('ru-RU') }}
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Нижняя панель с кнопкой -->
            <div class="mt-8 flex justify-end">
                <button class="bg-stone-800 text-stone-50 px-10 py-4 rounded text-[10px] uppercase tracking-[0.2em] font-bold hover:bg-stone-700 transition-all shadow-sm">
                    Оформить заказ
                </button>
            </div>
        </div>
    </div>
</template>
