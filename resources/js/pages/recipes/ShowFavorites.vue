<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import RecipeCard from '@/components/RecipeCard.vue';
import ActionCard from '@/components/ActionCard.vue';
import { Grid, Plus, Gift, Scroll } from 'lucide-vue-next';
import Paginator from '@/components/Paginator.vue';
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import LinkButton from '@/components/LinkButton.vue';

defineProps({
    favoriteRecipes: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Przepisy',
        href: route('recipes.index'),
    },
    {
        title: 'Ulubione przepisy',
        href: '/przepisy/ulubione',
    },
];
</script>

<template>
    <Head title="Ulubione przepisy" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-auto flex h-full w-full max-w-[1440px] flex-1 flex-col gap-8 rounded-xl p-4">
            <div class="grid gap-4 xl:grid-cols-3">
                <ActionCard title="Dodaj nowy przepis" :icon="Plus" :href="route('recipes.create')" class="h-42 w-full" />
                <ActionCard title="Wszystkie przepisy" :icon="Scroll" :href="route('recipes.index')" class="h-42 w-full" />
                <ActionCard title="Wylosuj ulubiony przepis" :icon="Gift" :href="route('recipes.randomFavorite')" class="h-42 w-full" />
            </div>

            <div class="flex flex-col gap-y-4">
                <h2 class="border-b border-gray-300 py-6 text-2xl font-bold">Twoje ulubione przepisy</h2>
                <div
                    v-if="favoriteRecipes"
                    class="relative grid h-[100vh] flex-1 gap-x-4 gap-y-4 rounded-xl border-sidebar-border/70 md:min-h-min lg:grid-cols-2 dark:border-sidebar-border"
                >
                    <RecipeCard v-for="recipe in favoriteRecipes.data" :key="recipe.id" :recipe="recipe" />
                </div>
                                <Paginator v-if="favoriteRecipes?.data?.length" :recipes="favoriteRecipes" />
            </div>

            <div v-if="!favoriteRecipes?.data?.length" class="flex flex-col items-center justify-center h-full">
                <h3 class="text-2xl text-center">Nie masz jeszcze żadnych ulubionych przepisów</h3>

                <div class="flex gap-2 mt-4">

                <LinkButton :href="route('recipes.index')">
                    Wszystkie przepisy
                </LinkButton>

                <LinkButton :href="route('categories.index')">
                    Wszystkie kategorie
                </LinkButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
