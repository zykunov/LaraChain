<template>
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 text-center">Список цепочек</h2>

        <!-- Спиннер загрузки -->
        <div v-if="loading" class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent mb-4"></div>
            <p class="text-gray-600 text-lg">Загрузка...</p>
        </div>

        <!-- Ошибка -->
        <div
            v-else-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-6 text-center"
        >
            <p class="text-red-600 font-semibold text-base">Ошибка загрузки данных: {{ error }}</p>
        </div>

        <!-- Список цепочек -->
        <div v-else>
            <!-- Карточки цепочек -->
            <div
                v-for="chain in validChains"
                :key="chain.id"
                class="mb-4"
            >
                <router-link
                    :to="{ name: 'ChainBlocksView', params: { id: chain.id } }"
                    class="block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 p-4 sm:p-5 hover:bg-gray-50"
                >
                    <h3 class="text-xl font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                        Цепочка #{{ chain.id }}
                    </h3>
                </router-link>
            </div>

            <!-- Сообщение об отсутствии данных -->
            <div
                v-if="validChains.length === 0"
                class="text-center py-8"
            >
                <p class="text-gray-500 italic text-lg sm:text-xl">Нет доступных цепочек или все ID некорректны</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ChainList',
    data() {
        return {
            chains: [],
            loading: true,
            error: null
        };
    },
    computed: {
        validChains() {
            return this.chains
                .map(chain => this.validateChain(chain))
                .filter(chain => chain !== null);
        }
    },
    async mounted() {
        await this.fetchChains();
    },
    methods: {
        validateChain(chain) {
            // Проверяем наличие ID
            if (!chain.id && chain.id !== 0) {
                console.warn('Пропущено звено без ID:', chain);
                return null;
            }

            // Преобразуем ID в число
            const numericId = parseInt(chain.id, 10);

            // Валидируем ID: должен быть целым и положительным
            if (isNaN(numericId) || !Number.isInteger(numericId) || numericId <= 0) {
                console.warn(`Некорректный ID цепочки: ${chain.id}. Пропускаем звено.`, chain);
                return null;
            }

            // Возвращаем исправленную цепочку
            return {
                ...chain,
                id: numericId
            };
        },
        async fetchChains() {
            try {
                const response = await fetch('/api/blockchain/chains');

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                // Проверяем, что данные — массив
                if (!Array.isArray(data)) {
                    console.error('Ответ API не является массивом:', data);
                    this.chains = [];
                    return;
                }

                this.chains = data;
            } catch (err) {
                console.error('Ошибка загрузки цепочек:', err);
                this.error = err.message || 'Не удалось загрузить список цепочек';
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

<style scoped>

</style>
