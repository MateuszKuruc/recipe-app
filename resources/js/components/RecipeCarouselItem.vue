<script setup lang="ts">
import LinkButton from '@/components/LinkButton.vue';

defineProps<{
    image: string;
    title: string;
    excerpt: string;
    link: string;
}>();
</script>

<template>
    <div class="flex justify-center items-center w-full h-full relative">
        <img :src="image" alt="" class="w-full h-[450px] object-cover" />
        <div class="absolute flex flex-col items-center gap-2 top-1/2 -translate-y-1/2 text-center px-4">
            <h2 class="text-3xl font-bold">{{ title }}</h2>
            <p class="text-lg text-muted-foreground">{{ excerpt }}</p>
            <LinkButton :href="link">Sprawdź przepis</LinkButton>
        </div>
    </div>
</template>
