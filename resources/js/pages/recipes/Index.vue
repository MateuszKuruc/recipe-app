<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import RecipeCard from '@/components/RecipeCard.vue';
import ActionCard from '@/components/ActionCard.vue';
import { Grid, Plus, Gift } from 'lucide-vue-next';
import Paginator from '@/components/Paginator.vue';
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';

defineProps({
    recipes: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Przepisy',
        href: '/recipes',
    },
];

const page = usePage();

const searchField = ref(page.props.searchField || '');

const url = route('recipes.index');

watch(
    searchField,
    debounce(() => {
        router.get(
            url,
            { searchField: searchField.value },
            {
                preserveState: true,
                preserveScroll: true,
                only: ['recipes'],
            },
        );
    }, 300),
);
</script>

<template>
    <Head title="Przepisy" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-auto flex h-full w-full max-w-[1440px] flex-1 flex-col gap-8 rounded-xl p-4">
            <div class="flex flex-col items-center py-16">
                <Input v-model="searchField" placeholder="Szukaj przepisów..." class="h-12 w-[400px] rounded-xl" />
            </div>

            <div class="grid gap-4 xl:grid-cols-3">
                <ActionCard title="Dodaj nowy przepis" :icon="Plus" :href="route('recipes.create')" class="h-42 w-full" />
                <ActionCard title="Wszystkie kategorie" :icon="Grid" :href="route('categories.index')" class="h-42 w-full" />
                <ActionCard title="Wylosuj przepis" :icon="Gift" :href="route('recipes.random')" class="h-42 w-full" />
            </div>

            <div class="flex flex-col gap-y-4">
                <h2 class="border-b py-6 text-2xl font-bold">Wszystkie przepisy</h2>
                <div
                    class="relative grid min-h-[100vh] flex-1 gap-x-4 gap-y-4 rounded-xl border-sidebar-border/70 md:min-h-min lg:grid-cols-2 dark:border-sidebar-border"
                >
                    <RecipeCard v-for="recipe in recipes.data" :key="recipe.id" :recipe="recipe" />
                </div>
                <Paginator :recipes="recipes" />
            </div>
        </div>
    </AppLayout>
</template>
