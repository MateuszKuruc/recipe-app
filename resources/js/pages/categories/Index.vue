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
    recipes: Object,
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Recipes',
        href: '/recipes',
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 rounded-xl p-4">
            <div class="flex flex-col items-center py-8">
                <Input placeholder="Search..." class="w-[400px]" />
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <ActionCard title="View All Categories" :icon="Grid" :href="route('home')" />
                <ActionCard title="Add New Recipe" :icon="Plus" :href="route('home')" />
                <ActionCard title="Latest Recipes" :icon="Clock" :href="route('home')" />
            </div>

            <div class="flex flex-col gap-y-4">
                <h2 class="text-2xl font-bold border-b py-4">All Recipes</h2>
                <div class="relative min-h-[100vh] flex-1 grid grid-cols-2 gap-x-4 gap-y-4 rounded-xl border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <RecipeCard v-for="recipe in recipes.data" :key="recipe.id"  :recipe="recipe"  />
                </div>

                <div>
                    <Paginator :recipes="recipes" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
