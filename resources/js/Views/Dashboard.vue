
<template>
    <div class="page-content">
        <h2>Главная панель</h2>
        <div class="chart-grid">
            <div class="chart-card">
                <h4>График продаж</h4>
                <div class="chart-placeholder">График продаж</div>
            </div>
            <div class="chart-card">
                <h4>Активность пользователей</h4>
                <div class="chart-placeholder">График активности</div>
            </div>
        </div>
    </div>
</template>

<script setup>
// Логика для графиков
</script>

<style scoped>
.chart-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}
.chart-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}
</style>
