<template>
    <div class="app-layout">
        <!-- Верхняя панель навигации -->
        <header class="top-nav">
            <div class="nav-brand">
                <h2>Аналитика платформы</h2>
            </div>
            <div class="nav-actions">
                <span>Добро пожаловать, {{ userName }}</span>
                <button @click="logout" class="btn-logout">Выйти</button>
            </div>
        </header>

        <div class="main-content">
            <!-- Левая панель -->
            <aside class="sidebar">
                <nav class="sidebar-nav">
                    <ul>
                        <li
                            v-for="item in menuItems"
                            :key="item.path"
                            :class="{ 'active': currentRoute === item.path }"
                        >
                            <router-link
                                :to="item.path"
                                class="nav-link"
                            >
                                <i class="icon">{{ item.icon }}</i>
                                {{ item.title }}
                            </router-link>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Правая панель с содержимым страниц -->
            <main class="content-area">
                <router-view />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const userName = ref('Администратор');
const router = useRouter();
const route = useRoute();

// Меню навигации
const menuItems = ref([
    {
        path: '/dashboard',
        title: 'Главная',
        icon: '📊'
    },
    {
        path: '/сhains',
        title: 'Цепочки',
        icon: '📈'
    },
]);

// Подсветка активного пункта меню
const currentRoute = computed(() => route.path);

function logout() {
    alert('Выход из системы');
    router.push('/login');
}
</script>

<style scoped>
.app-layout {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.top-nav {
    background: #2c3e50;
    color: white;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-brand h2 {
    margin: 0;
}

.nav-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-logout {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
}

.main-content {
    display: flex;
    flex: 1;
}

.sidebar {
    width: 250px;
    background: #34495e;
    color: white;
    padding: 1rem 0;
    height: calc(100vh - 60px);
    position: fixed;
    left: 0;
    top: 60px;
}

.sidebar-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-nav li {
    padding: 0.8rem 1.5rem;
}

.nav-link {
    color: #ecf0f1;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.5rem 0;
}

.sidebar-nav .active {
    background: #1a252f;
}

.icon {
    font-size: 1.2rem;
}

.content-area {
    flex: 1;
    margin-left: 250px; /* Отступ для левой панели */
    padding: 2rem;
    overflow-y: auto;
    background: #f5f7fa;
}

/* Адаптивность для мобильных устройств */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }
    .content-area {
        margin-left: 200px;
    }
}
</style>
