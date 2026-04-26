import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.interceptors.request.use(config => {
    const token = localStorage.getItem('admin_token'); // Проверь отсутствие пробела!
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});
