<script setup lang="ts">
import Paginator from '@/components/Paginator.vue';
import RecipeCard from '@/components/RecipeCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import NoResultsSection from '@/pages/categories/NoResultsSection.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    category: Object,
    recipes: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kategorie',
        href: '/kategorie',
    },
    {
        title: props.category?.name || '',
        href: `/kategorie/${props.category?.slug}`,
    },
];
</script>

<template>
    <Head :title="category.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 rounded-xl p-6">
            <div class="flex flex-col gap-4">
                <h2 class="border-b border-gray-300 py-4 text-2xl font-bold">
                    Wszystkie <span class="text-rose-600 lowercase">{{ category.name }}</span>
                </h2>
                <NoResultsSection
                    :displayData="!recipes.data.length"
                    buttonLabel="Sprawdź pozostałe kategorie"
                    :buttonUrl="route('categories.index')"
                />
                <div v-if="recipes.data.length">
                    <div
                        class="relative grid min-h-[100vh] flex-1 grid-cols-1 gap-x-4 gap-y-4 rounded-xl border-sidebar-border/70 md:min-h-min md:grid-cols-2 dark:border-sidebar-border"
                    >
                        <RecipeCard v-for="recipe in recipes.data" :key="recipe.id" :recipe="recipe" :currentSlug="recipe.category.slug" />
                    </div>
                    <Paginator :recipes="recipes" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
