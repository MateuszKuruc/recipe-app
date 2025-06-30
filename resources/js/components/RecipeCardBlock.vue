<template>
    <div class="rounded-lg overflow-hidden">
        <img
            :src="image"
            :alt="title"
            class="w-full h-48 object-cover"
        />
        <div class="mt-4">
            <h3 class="text-red-600 text-lg font-bold leading-snug">
                {{ title }}
            </h3>
            <p class="text-sm text-gray-600 mt-1">{{ subtitle }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    image: string;
    title: string;
    subtitle?: string;
}>();
</script>
