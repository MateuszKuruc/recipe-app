<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    image: string;
    title: string;
    href: string;
}>();
</script>

<template>
    <div class="overflow-hidden rounded-lg">
        <Link :href="href">
            <img :src="image" :alt="title" class="h-48 w-full object-cover" />
        </Link>
        <div class="mt-4">
            <Link :href="href">
                <h3 class="text-lg leading-snug font-bold text-orange-500">
                    {{ title }}
                </h3>
            </Link>

        </div>
    </div>
</template>
