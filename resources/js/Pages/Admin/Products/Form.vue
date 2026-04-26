    <script setup>
    import { ref, onMounted } from 'vue';
    import { router, Head, Link } from '@inertiajs/vue3';

    const props = defineProps({
        product: Object,
        categories: Array,
    });

    const form = ref({
        name: props.product?.name || '',
        category_id: props.product?.category_id || '',
        description: props.product?.description || '',
        price: props.product?.price || '',
    });

    const processing = ref(false);
    const errors = ref({});

    onMounted(() => {
        if (!localStorage.getItem('admin_token')) router.visit('/login');
    });

    const submit = async () => {
        processing.value = false;
        errors.value = {};

        try {
            if (props.product) {
                // РЕДАКТИРОВАНИЕ
                await axios.put(`/api/products/${props.product.id}`, form.value);
            } else {
                // СОЗДАНИЕ
                await axios.post('/api/products', form.value);
            }

            // После успеха — редирект в список через Inertia
            router.visit('/admin/products');
        } catch (e) {
            if (e.response?.status === 422) {
                errors.value = e.response.data.errors;
            } else {
                alert('Произошла ошибка при сохранении');
            }
        } finally {
            processing.value = false;
        }
    };
    </script>

    <template>
        <Head :title="product ? 'Редактировать товар' : 'Новый товар'" />

        <div class="min-h-screen bg-[#F7F5F2] py-12">
            <div class="max-w-2xl mx-auto px-6">

                <Link href="/admin/products" class="text-[10px] uppercase tracking-widest font-bold text-stone-400 hover:text-stone-800 transition flex items-center mb-8">
                    ← Назад к списку
                </Link>

                <div class="bg-white p-8 rounded-lg border border-stone-200 shadow-sm">
                    <h1 class="text-2xl font-semibold text-stone-800 mb-10">
                        {{ product ? 'Редактировать товар' : 'Добавить товар' }}
                    </h1>

                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Название -->
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-stone-400 mb-2 ml-1">Название</label>
                            <input v-model="form.name" type="text" required
                                   class="block w-full border-stone-200 focus:ring-stone-400 focus:border-stone-400 text-sm rounded-md py-3 transition-all" />
                            <span v-if="errors.name" class="text-red-400 text-xs mt-1">{{ errors.name[0] }}</span>
                        </div>

                        <!-- Категория -->
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-stone-400 mb-2 ml-1">Категория</label>
                            <select v-model="form.category_id" required
                                    class="block w-full border-stone-200 focus:ring-stone-400 focus:border-stone-400 text-sm rounded-md py-3 transition-all">
                                <option value="">Выберите категорию</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                        </div>

                        <!-- Описание -->
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-stone-400 mb-2 ml-1">Описание</label>
                            <textarea v-model="form.description" rows="4"
                                      class="block w-full border-stone-200 focus:ring-stone-400 focus:border-stone-400 text-sm rounded-md py-3 transition-all"></textarea>
                        </div>

                        <!-- Цена -->
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-stone-400 mb-2 ml-1">Цена (₽)</label>
                            <input v-model="form.price" type="number" step="1" min="0" required
                                   class="block w-full border-stone-200 focus:ring-stone-400 focus:border-stone-400 text-sm rounded-md py-3 transition-all" />
                        </div>

                        <!-- Кнопка отправки -->
                        <div class="pt-6">
                            <button type="submit" :disabled="processing"
                                    class="w-full bg-stone-800 text-stone-50 py-4 rounded text-[10px] uppercase tracking-[0.2em] font-bold hover:bg-stone-700 transition disabled:opacity-50 shadow-md">
                                {{ processing ? 'Сохранение...' : (product ? 'Обновить товар' : 'Создать товар') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
