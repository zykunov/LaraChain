<template>
    <div class="chain-list">
        <h2>Список цепочек</h2>

        <div v-if="loading">Загрузка...</div>

        <div v-else-if="error" class="error">
            Ошибка загрузки данных: {{ error }}
        </div>

        <div v-else>
            <div
                v-for="chain in chains"
                :key="chain.id"
                class="chain-item"
            >
                <h3>Цепочка #{{ chain.id }}</h3>
                <div class="chain-data">
                    <strong>Данные цепочки:</strong>
                    <ul>
                        <li v-for="(value, index) in chain.chain" :key="index">
                            {{ index }}: {{ value }}
                        </li>
                    </ul>
                </div>
            </div>

            <div v-if="chains.length === 0" class="no-data">
                Данные не найдены
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
    async mounted() {
        await this.fetchChains();
    },
    methods: {
        async fetchChains() {
            try {
                const response = await fetch('/api/blockchain/chains');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.chains = await response.json();
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

<style scoped>
.chain-list {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.chain-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    background: #f9f9f9;
}

.chain-data {
    margin-top: 10px;
}

.error {
    color: #d32f2f;
    text-align: center;
    font-weight: bold;
}

.no-data {
    text-align: center;
    color: #666;
    font-style: italic;
}
</style>
