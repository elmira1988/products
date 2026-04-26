<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Head, Link } from '@inertiajs/vue3';

const products = ref([]);
const categories = ref([]);
const loading = ref(true);

// Функция загрузки данных через API с токеном
const fetchData = async () => {
    try {
        const response = await axios.get('/api/products');
        // В API пагинации данные лежат в response.data.data
        products.value = response.data.data;
        loading.value = false;
    } catch (error) {
        if (error.response?.status === 401) {
            window.location.href = '/login';
        }
    }
};

// Функция удаления
const deleteProduct = async (id) => {
    if (!confirm('Вы уверены, что хотите удалить этот товар?')) return;

    try {
        await axios.delete(`/api/products/${id}`);
        // Обновляем список после удаления
        products.value = products.value.filter(p => p.id !== id);
    } catch (error) {
        alert('Ошибка при удалении');
    }
};

onMounted(() => {
    fetchData();
});
</script>

<template>
    <Head title="Управление товарами" />

    <div class="min-h-screen bg-[#F7F5F2] py-12">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex justify-between items-center mb-10">
                <h1 class="text-2xl font-semibold text-stone-800 tracking-tight">Управление товарами</h1>

                <Link
                    href="/admin/products/create"
                    class="bg-stone-800 text-stone-50 px-6 py-2.5 rounded text-[10px] uppercase tracking-widest font-bold hover:bg-stone-700 transition shadow-sm"
                >
                    Добавить товар
                </Link>
            </div>

            <div v-if="loading" class="text-center py-20 text-stone-400 uppercase text-[10px] tracking-widest font-bold">
                Загрузка данных...
            </div>

            <div v-else class="bg-white rounded-lg border border-stone-200 overflow-hidden shadow-sm">
                <table class="min-w-full divide-y divide-stone-100">
                    <thead class="bg-stone-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] uppercase tracking-widest font-bold text-stone-400">Товар</th>
                        <th class="px-6 py-4 text-left text-[10px] uppercase tracking-widest font-bold text-stone-400">Категория</th>
                        <th class="px-6 py-4 text-left text-[10px] uppercase tracking-widest font-bold text-stone-400">Цена</th>
                        <th class="px-6 py-4 text-right text-[10px] uppercase tracking-widest font-bold text-stone-400">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                    <tr v-for="product in products" :key="product.id" class="hover:bg-stone-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-stone-800">{{ product.name }}</div>
                        </td>
                        <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-stone-100 text-stone-500 border border-stone-200">
                                    {{ product.category?.name || 'Нет категории' }}
                                </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-stone-600">
                            {{ product.price }} ₽
                        </td>
                        <td class="px-6 py-4 text-right space-x-4">
                            <Link
                                :href="`/admin/products/${product.id}/edit`"
                                class="text-stone-400 hover:text-stone-800 text-[10px] uppercase font-bold tracking-widest underline underline-offset-4"
                            >
                                Изм.
                            </Link>
                            <button
                                @click="deleteProduct(product.id)"
                                class="text-red-300 hover:text-red-600 text-[10px] uppercase font-bold tracking-widest underline underline-offset-4"
                            >
                                Удал.
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
