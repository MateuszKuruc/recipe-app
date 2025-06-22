<script setup lang="ts">
import RecipeBadge from '@/components/RecipeBadge.vue';

defineProps({
recipe: Object,
})
</script>

<template>
    <div class="relative bg-white p-4 flex flex-col space-y-2">

        <img :src="recipe.main_image" alt="Recipe image" class="rounded-xl w-full object-cover">
        <RecipeBadge :tags="recipe.tags" />
        <h2 class="text-lg font-semibold text-red-600">{{ recipe.title }}</h2>
        <p class="text-sm text-gray-600">{{ recipe.excerpt }}</p>
    </div>

</template>

