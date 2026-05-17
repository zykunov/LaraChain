<script setup>
    const clients = [
    {
        id: 1,
        name: 'Howell Hand',
        company: 'Kiehn-Green',
        city: 'Emelyside',
        progress: 60,
        created: 'Mar 3, 2025'
    },
    {
        id: 2,
        name: 'Hope Howe',
        company: 'Nolan Inc',
        city: 'Paristown',
        progress: 30,
        created: 'Dec 1, 2025'
    },
    {
        id: 3,
        name: 'Nelson Jerde',
        company: 'Nitzsche LLC',
        city: 'Jailynbury',
        progress: 80,
        created: 'May 18, 2025'
    },
    {
        id: 4,
        name: 'Kim Weimann',
        company: 'Brown-Lueillty',
        city: 'New Emile',
        progress: 45,
        created: 'May 4, 2025'
    }
    ];
</script>

<template>
    <div class="space-y-6">
        <!-- Блок Trends overview -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-lg font-bold mb-4 flex items-center">
                <svg class="w-4 h-4 text-primary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Trends overview
            </h2>
            <!-- Здесь будет ваш компонент графика -->
            <div class="h-64 bg-gray-200 rounded-lg"></div> <!-- заглушка -->
        </div>

        <!-- Блок Clients -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-lg font-bold mb-4 flex items-center">
                <svg class="w-4 h-4 text-primary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Clients
            </h2>

            <table class="w-full text-sm">
                <thead>
                <tr class="text-gray-700 border-b border-gray-200">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Company</th>
                    <th class="px-4 py-2">City</th>
                    <th class="px-4 py-2">Progress</th>
                    <th class="px-4 py-2">Created</th>
                    <th class="px-4 py-2"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="client in clients" :key="client.id" class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="px-4 py-2 flex items-center">
                        <span class="w-4 h-4 bg-gray-300 rounded-full mr-2"></span>
                        {{ client.name }}
                    </td>
                    <td class="px-4 py-2">{{ client.company }}</td>
                    <td class="px-4 py-2">{{ client.city }}</td>
                    <td class="px-4 py-2">
                        <div class="w-32 h-2 bg-gray-200 rounded-full">
                            <div class="h-full bg-blue-500" :style="{ width: client.progress + '%' }"></div>
                        </div>
                    </td>
                    <td class="px-4 py-2">{{ client.created }}</td>
                    <td class="px-4 py-2">
                        <!-- Кнопки действий -->
                        <button class="bg-blue-500 text-white px-2 py-1 rounded-full mr-2">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded-full">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>
