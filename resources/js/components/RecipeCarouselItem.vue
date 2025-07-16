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
    <div class="relative w-full h-[450px] overflow-hidden rounded-lg shadow-lg">
        <!-- Background image -->
        <img :src="image" alt="" class="w-full h-full object-cover" />

        <!-- Gradient overlay with optional blur -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/70 to-black/20 z-10"></div>


        <!-- Content -->
        <div
            class="absolute inset-0 z-20 flex flex-col justify-center items-center text-center px-6 md:px-10 text-white gap-2"
        >
            <h2 class="text-3xl md:text-4xl font-extrabold drop-shadow-lg sentence-case">{{ title }}</h2>
            <p class="mt-2 text-base md:text-lg max-w-2xl text-white/90 leading-relaxed sentence-case">
                {{ excerpt }}
            </p>
            <LinkButton
                :href="link"

            >
                Sprawdź przepis
            </LinkButton>
        </div>
    </div>
</template>


