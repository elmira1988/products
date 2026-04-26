<script setup>
import { onMounted } from 'vue';
import { router, Link, Head } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    products: Object,
});

// Проверка авторизации: если токена нет в памяти, выкидываем на логин
onMounted(() => {
    if (!localStorage.getItem('admin_token')) {
        router.visit('/login');
    }
});

// Функция выхода
const logout = () => {
    if (confirm('Вы уверены, что хотите выйти?')) {
        localStorage.removeItem('admin_token'); // Удаляем ключ
        window.location.href = '/login'; // Редирект на вход
    }
};

// Функция удаления товара
const deleteProduct = async (id) => {
    if (!confirm('Удалить этот товар?')) return;

    try {
        await axios.delete(`/api/products/${id}`);
        router.reload({ preserveScroll: true }); // Обновляем список через Inertia
    } catch (e) {
        alert(e.response?.data?.message || 'Ошибка при удалении');
    }
};
</script>

<template>
    <Head title="Администрирование товаров" />

    <div class="min-h-screen bg-[#F7F5F2] py-3">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex justify-end">
                <button
                    @click="logout"
                    class="text-[10px] uppercase tracking-[0.2em] font-bold text-stone-400 hover:text-red-500 transition-colors flex items-center bg-white py-2 px-4 rounded-full border border-stone-200 shadow-sm"
                >
                    Выйти
                    <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 gap-6 pt-8">
                <div>
                    <h1 class="text-3xl font-semibold text-stone-800 tracking-tight">Управление товарами</h1>
                    <p class="text-stone-400 text-sm mt-2 font-medium tracking-wide">Всего товаров: {{ products.total }}</p>
                </div>

                <Link
                    href="/admin/products/create"
                    class="bg-stone-800 text-stone-50 px-8 py-3.5 rounded text-[10px] uppercase tracking-[0.2em] font-bold hover:bg-stone-700 transition shadow-md whitespace-nowrap text-center"
                >
                    + Добавить товар
                </Link>
            </div>

            <!-- СПИСОК ТОВАРОВ -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="product in products.data" :key="product.id" class="bg-white shadow-sm rounded-lg border border-stone-200/60 p-8 flex flex-col hover:shadow-md transition-shadow">

                    <div class="flex justify-between items-start mb-6">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] uppercase tracking-widest font-bold text-stone-300">ID: {{ product.id }}</span>
                            <h2 class="text-lg font-semibold text-stone-800 leading-tight">{{ product.name }}</h2>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <span class="text-xl font-medium text-stone-900">{{ product.price }} ₽</span>
                        <span class="px-2 py-1 rounded text-[10px] uppercase tracking-wider font-bold bg-stone-50 text-stone-400 border border-stone-100">
                            {{ product.category?.name }}
                        </span>
                    </div>

                    <div class="mt-auto pt-6 border-t border-stone-50 flex gap-4">
                        <Link
                            :href="`/admin/products/${product.id}/edit`"
                            class="flex-1 text-center py-3 text-[10px] uppercase tracking-widest font-bold border border-stone-200 text-stone-600 hover:border-stone-800 hover:text-stone-800 transition"
                        >
                            Редактировать
                        </Link>
                        <button
                            @click="deleteProduct(product.id)"
                            class="flex-1 py-3 text-[10px] uppercase tracking-widest font-bold border border-transparent bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition"
                        >
                            Удалить
                        </button>
                    </div>
                </div>
            </div>

            <!-- ПАГИНАЦИЯ -->
            <div class="mt-20 flex justify-center items-center gap-2">
                <Component
                    :is="link.url ? Link : 'span'"
                    v-for="link in products.links"
                    :key="link.label"
                    :href="link.url"
                    v-html="link.label"
                    class="px-5 py-3 text-[10px] font-bold uppercase tracking-widest border transition-all rounded-md"
                    :class="{
                        'bg-stone-800 text-white border-stone-800 shadow-sm': link.active,
                        'text-stone-200 border-transparent pointer-events-none': !link.url,
                        'text-stone-500 border-stone-200 hover:bg-white hover:border-stone-400': link.url && !link.active
                    }"
                />
            </div>
        </div>
    </div>
</template>




