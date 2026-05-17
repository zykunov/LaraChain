<template>
    <div class="flex h-screen bg-slate-50">
        <!-- Левая панель (Sidebar) -->
        <aside
            class="sidebar w-64 bg-white border-r border-slate-200 h-full fixed left-0 top-0 bottom-0 mt-3 mb-3 ml-3 rounded-lg shadow-md overflow-y-auto z-20 transition-transform duration-300 ease-in-out"
            :class="{ 'translate-x-0': sidebarOpen }"
        >
            <nav class="sidebar-nav py-6">
                <ul class="space-y-1 px-4">
                    <li
                        v-for="item in menuItems"
                        :key="item.path"
                        class="relative"
                    >
                        <router-link
                            :to="item.path"
                            class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-primary-50 hover:text-primary-600 transition-all duration-200"
                            :class="{ 'bg-primary-50 text-primary-600': currentRoute === item.path }"
                        >
                            <span class="text-lg">{{ item.icon }}</span>
                            <span class="font-medium truncate">
                <span class="hidden md:inline">{{ item.title }}</span>
              </span>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Верхняя панель навигации (Header) -->
        <header class=" bg-slate-50 px-6 py-4 flex justify-between items-center  fixed top-0 left-64 right-0 z-30">
            <div class="nav-brand flex items-center gap-3">
                <button
                    @click="toggleSidebar"
                    class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <span class="text-xl font-semibold text-slate-800">Laravel Blockchain</span>
            </div>
            <div class="nav-actions flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-primary-600 font-medium text-sm">A</span>
                    </div>
                    <span class="text-sm font-medium text-slate-700">Добро пожаловать, {{ userName }}</span>
                </div>
                <button
                    @click="logout"
                    class="bg-danger-500 hover:bg-danger-600 text-white px-4 py-2 rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-danger-400 focus:ring-offset-2"
                >
                    Выйти
                </button>
            </div>
        </header>

        <!-- Основной контент -->
        <main class="content-area flex-1 p-6 bg-slate-50 overflow-y-auto mt-16 ml-64">
            <router-view />
        </main>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const userName = ref('Администратор');
const sidebarOpen = ref(false);
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
        path: '/chains',
        title: 'Цепочки',
        icon: '📈'
    }
]);

// Подсветка активного пункта меню
const currentRoute = computed(() => route.path);

function toggleSidebar() {
    sidebarOpen.value = !sidebarOpen.value;
}


</script>


