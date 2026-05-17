<template>
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Спиннер загрузки -->
        <div v-if="loading" class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent mb-4"></div>
            <p class="text-gray-700 text-lg font-medium">Загрузка блоков цепочки...</p>
        </div>

        <!-- Ошибка -->
        <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
            <p class="text-red-600 font-semibold text-base mb-4">Ошибка: {{ error }}</p>
            <button
                @click="fetchBlocks"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
            >
                Повторить
            </button>
        </div>

        <!-- Список блоков -->
        <div v-else>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-8">
                Цепочка #{{ numericChainId }} — {{ blocks.length }} блоков
            </h2>

            <div v-if="blocks.length === 0" class="text-center py-12">
                <p class="text-gray-500 italic text-lg">В этой цепочке пока нет блоков</p>
            </div>

            <div
                v-else
                v-for="block in blocks"
                :key="block.id"
                class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-6 transition-transform duration-200 hover:shadow-xl hover:-translate-y-1"
            >
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-200 pb-4 mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 sm:mb-0">Блок #{{ block.id }}</h3>
                    <span class="text-gray-600 text-sm font-medium">{{ formatTimestamp(block.timestamp) }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-700 min-w-[120px] mr-4">Данные:</span>
                        <span class="text-gray-900 break-words flex-grow text-right">{{ block.data }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-700 min-w-[120px] mr-4">ID цепочки:</span>
                        <span class="text-gray-900 break-words flex-grow text-right">{{ block.chain_id }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-700 min-w-[120px] mr-4">Создан:</span>
                        <span class="text-gray-900 break-words flex-grow text-right">{{ formatDate(block.created_at) }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-700 min-w-[120px] mr-4">Обновлён:</span>
                        <span class="text-gray-900 break-words flex-grow text-right">{{ formatDate(block.updated_at) }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-700 min-w-[120px] mr-4">Предыдущий хэш:</span>
                        <span class="bg-gray-100 text-gray-800 font-mono text-sm px-3 py-1 rounded-md break-all flex-grow text-right">
              {{ block.previous_hash || 'Нет предыдущего' }}
            </span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-700 min-w-[120px] mr-4">Хэш:</span>
                        <span class="bg-gray-100 text-gray-800 font-mono text-sm px-3 py-1 rounded-md break-all flex-grow text-right">
              {{ block.hash }}
            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ChainBlocksView',
    props: {
        chainId: {
            type: [String, Number],
            required: true
        }
    },
    data() {
        return {
            blocks: [],
            loading: false,
            error: null,
            numericChainId: null
        };
    },

    mounted() {
        console.log('ChainBlocksView mounted. chainId:', this.chainId);
        this.initializeChainId();
        if (this.numericChainId !== null) {
            this.fetchBlocks();
        }
    },
    methods: {
        initializeChainId() {
            const id = parseInt(this.chainId, 10);
            if (Number.isInteger(id) && id > 0) {
                this.numericChainId = id;
            } else {
                console.error('Некорректный ID цепочки:', this.chainId);
                this.error = 'Некорректный ID цепочки. Проверьте параметры маршрута.';
            }
        },
        async fetchBlocks() {
            if (this.numericChainId === null) {
                return; // Прерываем загрузку, если ID некорректен
            }

            this.loading = true;
            this.error = null;

            try {
                const response = await fetch(`/api/blockchain/chain/${this.numericChainId}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                this.blocks = await response.json();
            } catch (err) {
                console.error('Ошибка загрузки блоков:', err);
                this.error = err.message || 'Не удалось загрузить блоки цепочки';
            } finally {
                this.loading = false;
            }
        },
        formatDate(dateString) {
            if (!dateString) return 'Не указано';
            const date = new Date(dateString);
            return date.toLocaleDateString('ru-RU', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        formatTimestamp(timestamp) {
            if (!timestamp) return 'Не указана';
            const date = new Date(timestamp * 1000);
            return date.toLocaleString('ru-RU');
        }
    }
};
</script>

<style scoped>

</style>
