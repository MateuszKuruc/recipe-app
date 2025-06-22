<script setup lang="ts">
import { defineProps } from 'vue';
import { type Component } from 'vue';
import { Link } from '@inertiajs/vue3';

interface Props {
    title: string;
    icon: Component;
    href: string;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="relative aspect-video overflow-hidden rounded-xl border ">
        <Link
            :href="href"
            class="w-full h-full flex flex-col items-center justify-center rounded-lg border border-gray-200 p-4 text-center shadow-sm transition hover:shadow-md hover:bg-gray-50 "
        >
            <component :is="icon" class="h-6 w-6 mb-2 text-gray-600"/>
            <span class="text-sm font-medium">{{ title }}</span>
        </Link>
    </div>
</template>
