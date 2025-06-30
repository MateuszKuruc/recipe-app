<script setup lang="ts">
import { defineProps } from 'vue';
import { type Component } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import LinkButton from '@/components/LinkButton.vue';

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
    <div class="relative aspect-video overflow-hidden rounded-xl border">
        <img :src="image" alt="" />

        <!-- Outer clickable card -->
        <Link
            :href="href"
            class="flex h-full w-full flex-col items-center justify-center gap-1 rounded-lg border border-gray-200 p-4 text-center shadow-sm transition hover:bg-gray-50 hover:shadow-md"
        >
            <component v-if="icon" :is="icon" class="mb-2 h-6 w-6 text-gray-600" />
            <span v-if="count" class="font-bold">Przepisy: {{ count }}</span>
            <span class="text-2xl font-bold text-red-500 hover:text-red-600">{{ title }} </span>
        </Link>

        <!-- Separate link (doesn't nest inside outer Link) -->
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2">
            <LinkButton variant="default" v-if="randomHref" :href="randomHref">Wylosuj przepis</LinkButton>
        </div>
    </div>
</template>

