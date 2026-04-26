<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = ref({
    email: '',
    password: '',
});

const error = ref('');
const processing = ref(false);

const submit = async () => {
    error.value = '';
    processing.value = true;

    try {
        const response = await axios.post('/api/login', form.value);

        console.log(response.data);
        //Сохраняем токен в localStorage
        localStorage.setItem('admin_token', response.data.token);

        // Редирект в админку
        window.location.href = '/admin/products';
    } catch (e) {
        error.value = e.response?.data?.message || 'Ошибка авторизации. Проверьте данные.';
    } finally {
        processing.value = false;
    }
};
</script>

<template>
    <Head title="Вход в админку" />
    <div class="min-h-screen bg-[#F7F5F2] flex flex-col justify-center items-center px-6">

        <Link href="/" class="mb-8 text-2xl font-bold text-stone-800 tracking-tighter uppercase">
            Products<span class="text-stone-400 font-light">Store</span>
        </Link>

        <div class="w-full max-w-sm bg-white p-8 rounded-lg border border-stone-200/60 shadow-sm">
            <h1 class="text-sm font-bold uppercase tracking-[0.2em] text-stone-500 mb-8 text-center">
                Авторизация
            </h1>

            <div v-if="status" class="mb-4 text-xs font-medium text-green-600 text-center">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <!-- Email -->
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-stone-400 mb-2 ml-1">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        class="block w-full border-stone-200 focus:ring-stone-400 focus:border-stone-400 text-sm rounded-md shadow-sm bg-white text-stone-700 py-2.5 transition-all"
                        required
                        autofocus
                    />
                </div>

                <!-- Password -->
                <div class="mt-6">
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-stone-400 mb-2 ml-1">Пароль</label>
                    <input
                        v-model="form.password"
                        type="password"
                        class="block w-full border-stone-200 focus:ring-stone-400 focus:border-stone-400 text-sm rounded-md shadow-sm bg-white text-stone-700 py-2.5 transition-all"
                        required
                    />
                </div>

                <!-- Ошибка входа -->
                <div v-if="error" class="mt-4 text-[10px] font-bold text-red-400 uppercase tracking-tight text-center">
                    {{ error }}
                </div>

                <!-- Кнопка войти -->
                <div class="mt-8">
                    <button
                        type="submit"
                        :disabled="processing"
                        class="w-full bg-stone-800 text-stone-50 py-3 rounded text-[10px] uppercase tracking-[0.2em] font-bold hover:bg-stone-700 transition shadow-sm disabled:opacity-50"
                    >
                        {{ processing ? 'Вход...' : 'Войти' }}
                    </button>
                </div>

                <!-- Ссылка назад -->
                <div class="mt-6 text-center">
                    <Link
                        href="/"
                        class="text-[10px] uppercase tracking-widest font-bold text-stone-300 hover:text-stone-500 transition-colors"
                    >
                        Вернуться на сайт
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
