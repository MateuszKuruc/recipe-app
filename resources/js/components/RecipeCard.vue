<script setup lang="ts">
import RecipeBadge from '@/components/RecipeBadge.vue';
import { Link } from '@inertiajs/vue3';
import { Tag } from 'lucide-vue-next';

defineProps({
    recipe: Object,
    currentSlug: String
});
</script>

<template>
    <div class="relative flex flex-col space-y-2 bg-white p-4">
        <Link class="relative">
            <Link v-if="currentSlug !== recipe.category.slug" :href="route('categories.show', recipe.category.slug)" class="flex gap-2 bg-yellow-500 px-6 py-3 rounded-l-xl absolute right-0 top-5">
                <Tag />
            {{ recipe.category.name }}
            </Link>
        <Link :href="route('recipes.show', recipe.slug)">
            <img :src="recipe.main_image" alt="Recipe image" class="w-full rounded-xl object-cover" />
        </Link>
        </Link>

        <RecipeBadge :tags="recipe.tags" />
        <Link :href="route('recipes.show', recipe.slug)" class="w-max">
            <h2 class="text-lg font-semibold text-red-600">{{ recipe.title }}</h2>
        </Link>
        <p class="text-sm text-gray-600">{{ recipe.excerpt }}</p>
    </div>
</template>
