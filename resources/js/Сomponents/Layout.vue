<template>
    <div class="flex h-screen bg-gray-100 overflow-hidden">
        <!-- 1. Левая боковая панель (Sidebar) -->
        <aside class="w-64 bg-slate-900 text-white fixed top-0 left-0 h-full overflow-y-auto z-20">
            <div class="px-4 py-6">
                <h1 class="text-xl font-bold text-primary-400">Blockchain</h1>
            </div>

            <nav class="px-4">
                <ul class="space-y-1">
                    <li v-for="item in sidebarItems" :key="item.path">
                        <router-link
                            :to="item.path"
                            class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition-colors"
                        >
                            <span class="mr-3 text-xl">{{ item.icon }}</span>
                            <span>{{ item.title }}</span>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </aside>


        <main class="flex-1 ml-64 p-6 h-screen overflow-y-auto">
            <!-- Header -->
            <header class="flex items-center justify-between mb-6 border-b border-gray-200 pb-4">

                <!-- Left: Search -->
                <div class="flex items-center gap-4">
                    <input
                        type="text"
                        placeholder="Search..."
                        class="bg-gray-100 border border-gray-300 rounded-full px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    />
                </div>

                <!-- Right: User & Menu -->
                <div class="flex items-center gap-4">

                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium">John Doe</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <!-- Иконки уведомлений и настроек -->
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.69l-6-6a2.032 2.032 0 00-1.414 0L6 10.31a2.032 2.032 0 000 1.414l4.595 4.595a1.532 1.532 0 00.765 0z"></path>
                    </svg>
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </header>


            <!-- 2. Основная область (Content) -->
            <router-view />
        </main>
    </div>
</template>

<script setup>

const sidebarItems = [
    { icon: '📊', title: 'Статистика', path: '/dashboard' },
    { icon: '📁', title: 'Блок-чейн', path: '/chains' },
    { icon: '📁', title: 'блоки', path: '/blocks' },

];
</script>
