<script setup lang="ts">
import RecipeBadge from '@/components/RecipeBadge.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    image: String,
    title: String,
    href: String,
    tags: Array,
});
</script>

<template>
    <div class="flex h-full flex-col rounded-xl shadow bg-gradient-to-br from-white to-[#f9f9f9]">




    <!-- Image -->
        <Link :href="href" class="block">
            <img :src="image" :alt="title" class="aspect-[3/4] w-full object-cover rounded-xl" />
        </Link>

        <!-- Content -->
        <div class="flex flex-1 flex-col justify-between px-4 py-3 gap-3">
            <Link :href="href">
                <h3 class="text-lg leading-snug font-bold text-rose-700 break-words sentence-case">
                    {{ title }}
                </h3>
            </Link>
            <RecipeBadge :tags="tags" :is-name-displayed="false" />
        </div>
    </div>
</template>
