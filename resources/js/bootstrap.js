import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// --- 1. ПЕРЕХВАТЧИК ЗАПРОСОВ (Request) ---
// Срабатывает ДО того, как запрос уйдет на сервер.
// Мы "подкладываем" токен в каждый запрос.
window.axios.interceptors.request.use(config => {
    const token = localStorage.getItem('admin_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// --- 2. ПЕРЕХВАТЧИК ОТВЕТОВ (Response) ---
// Срабатывает ПОСЛЕ того, как сервер прислал ответ.
// Здесь мы обрабатываем ошибки (401, 404 и т.д.) глобально.
window.axios.interceptors.response.use(
    response => response, // Если код 200-299, просто возвращаем данные
    error => {
        // Если сервер ответил 401 (Токен неверный или протух)
        if (error.response?.status === 401) {
            localStorage.removeItem('admin_token');
            window.location.href = '/login';
        }

        // Если сервер ответил 404 (Товар не найден)
        if (error.response?.status === 404) {
            alert('Ресурс не найден (404)');
        }

        // Если сервер ответил 500 (Ошибка сервера)
        if (error.response?.status === 500) {
            alert('Ошибка на стороне сервера. Попробуйте позже.');
        }

        return Promise.reject(error);
    }
);
