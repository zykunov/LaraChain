<template>
    <div class="flex items-start gap-6 bg-white rounded-lg shadow-sm p-6 mb-4">
        <!-- Левая часть: Сумма и детали платежа -->
        <div class="flex-1 space-y-2">
            <!-- Сумма -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="text-sm text-gray-500 mr-2">{{ icon }}</span>
                    <span class="text-3xl font-bold text-black">{{ amount }}</span>
                </div>
                <span class="text-sm text-gray-500">{{ type }}</span>
            </div>

            <!-- Детали (дата и способ) -->
            <p class="text-sm text-gray-500">{{ date }} via {{ via }}</p>
        </div>

        <!-- Правая часть: Профиль и прогресс -->
        <div class="flex-1 space-y-2">
            <!-- Имя и дата -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                        <img :src="avatar" alt="Avatar" class="w-full h-full object-cover" />
                    </div>
                    <div>
                        <p class="text-lg font-bold text-black">{{ name }}</p>
                        <p class="text-sm text-gray-500">{{ createdAt }}</p>
                    </div>
                </div>

                <!-- Индикатор прогресса -->
                <div class="flex items-center">
                    <span class="text-sm text-white mr-1">{{ progress }}%</span>
                    <div class="w-4 h-4 rounded-full mr-1" :class="progressColor"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>



</script>
