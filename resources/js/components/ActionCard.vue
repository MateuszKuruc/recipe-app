<script setup lang="ts">
import LinkButton from '@/components/LinkButton.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, type Component } from 'vue';

interface Props {
    title: string;
    icon?: Component;
    href: string;
    count?: number;
    image?: string;
    randomHref?: string;
}

defineProps<Props>();
</script>

<template>
    <div class="relative aspect-video overflow-hidden rounded-xl border border-gray-300 shadow-xl">
        <img :src="image" alt="" />

        <Link
            :href="href"
            class="group flex h-full w-full flex-col items-center justify-center gap-1 rounded-lg border border-gray-300 p-4 text-center shadow-sm transition hover:bg-secondary hover:shadow-md"
        >
            <component v-if="icon" :is="icon" class="mb-2 h-6 w-6 text-gray-600 dark:text-gray-300 group-hover:text-white" />
            <span v-if="count" class="font-bold group-hover:text-white">Przepisy: {{ count }}</span>
            <span class="text-2xl font-bold text-teal-500">{{ title }}</span>
        </Link>


        <div class="absolute bottom-1/8 left-1/2 w-max -translate-x-1/2">
            <LinkButton variant="default" class="" v-if="randomHref" :href="randomHref">Wylosuj przepis</LinkButton>
        </div>
    </div>
</template>
