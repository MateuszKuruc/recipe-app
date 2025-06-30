<script setup lang="ts">
import ActionCard from '@/components/ActionCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Grid } from 'lucide-vue-next';

defineProps({
    categories: Array,
    totalRecipes: Number,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kategorie',
        href: '/kategorie',
    },
];
</script>

<template>
    <Head title="Kategorie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 rounded-xl p-4">
            <h1 class="text-4xl font-bold">Kolekcja przepisów</h1>

            <!--                <h2>Kolekcja przepisów</h2>-->
            <div class="grid auto-rows-min gap-3 md:grid-cols-2">
                <ActionCard
                    class="h-42 w-full"
                    v-for="category in categories"
                    :title="category.name"
                    :image="category.image"
                    :href="route('categories.show', category.slug)"
                    :count="category.recipes_count"
                    :random-href="category.random_recipe_slug"
                />
            </div>

            <div class="space-y-8">
                <h2 class="text-3xl pt-6 font-bold">Sprawdź też:</h2>
                <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                    <ActionCard title="Wszystkie przepisy" :icon="Grid" :href="route('recipes.index')" :count="totalRecipes" />
                    <ActionCard title="Najnowsze przepisy" :icon="Grid" href="" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
