<script setup lang="ts">
import LinkButton from '@/components/LinkButton.vue';
import RecipeCardBlock from '@/components/RecipeCardBlock.vue';

defineProps({
    label: String,
    href: String,
    buttonLabel: String,
    data: Array,
    isCategory: Boolean,
});
</script>

<template>
    <section class="mx-auto w-full max-w-6xl px-4">
        <div class="mb-8 flex flex-col items-center justify-between gap-4 border-b border-gray-300 pb-4 sm:flex-row sm:gap-0">
            <h2 class="text-3xl font-extrabold">
                <span v-if="isCategory">Kategoria: </span>
                <span class="text-orange-500">{{ label }}</span>
            </h2>
            <LinkButton :href="href" class="rounded-md border px-4 py-2 text-sm font-medium transition hover:bg-gray-100">
                {{ buttonLabel }}
            </LinkButton>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <RecipeCardBlock
                v-for="recipe in data"
                :key="recipe.id"
                :image="`/storage/${recipe.main_image}`"
                :title="recipe.title"
                :href="route('recipes.show', recipe.slug)"
                :tags="recipe.tags"
            />
        </div>
    </section>
</template>
