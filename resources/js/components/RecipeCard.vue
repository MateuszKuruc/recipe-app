<script setup lang="ts">
import RecipeBadge from '@/components/RecipeBadge.vue';
import { Link } from '@inertiajs/vue3';
import { Tag } from 'lucide-vue-next';

defineProps({
    recipe: Object,
    currentSlug: String,
});
</script>

<template>
    <div class="relative flex flex-col space-y-2 p-4 border-b border-gray-300">
        <div class="relative">
            <Link
                v-if="currentSlug !== recipe.category.slug"
                :href="route('categories.show', recipe.category.slug)"
                class="absolute top-5 right-0 flex gap-2 rounded-l-xl bg-yellow-500 px-6 py-3"
            >
                <Tag />
                {{ recipe.category.name }}
            </Link>
            <Link :href="route('recipes.show', recipe.slug)">
                <img :src="`/storage/${recipe.main_image}`" :alt="recipe.title" class="h-100 w-full rounded-xl object-cover" />
            </Link>
        </div>

        <RecipeBadge :tags="recipe.tags" />
        <Link :href="route('recipes.show', recipe.slug)" class="w-max">
            <h2 class="text-lg font-semibold text-orange-600 sentence-case">{{ recipe.title }}</h2>
        </Link>
        <p class="paragraph sentence-case">{{ recipe.excerpt }}</p>
    </div>
</template>
