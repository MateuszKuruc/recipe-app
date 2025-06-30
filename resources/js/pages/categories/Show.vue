<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input'
import RecipeCard from '@/components/RecipeCard.vue';
import ActionCard from '@/components/ActionCard.vue';
import { Grid, Plus, Clock } from 'lucide-vue-next';
import Paginator from '@/components/Paginator.vue';


defineProps({
    category: Object,
})


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kategoria',
        href: '/kategorie',
    }
];
</script>

<template>
    <Head title="Przepisy" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 rounded-xl p-6">

            <div class="flex flex-col gap-y-4">
                <h2 class="text-2xl font-bold border-b py-4">Wszystkie <span class="text-red-500 lowercase">{{ category.name }}</span></h2>
                <div class="relative min-h-[100vh] flex-1 grid grid-cols-2 gap-x-4 gap-y-4 rounded-xl border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <RecipeCard v-for="recipe in category.recipes" :key="recipe.id"  :recipe="recipe" :currentSlug="recipe.category.slug"  />

                </div>
<!--                <Paginator :recipes="recipes" />-->
            </div>

        </div>
    </AppLayout>
</template>
