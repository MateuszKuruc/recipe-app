<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import { Input } from '@/components/ui/input'
import RecipeCard from '@/components/RecipeCard.vue';

defineProps({
recipes: Array,
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
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex flex-col items-center">
                <Input placeholder="Search..." class="w-[400px]" />
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 grid grid-cols-2 space-x-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <RecipeCard v-for="recipe in recipes" :recipe="recipe" :key="recipe.id" />
<!--                <RecipeCard />-->
            </div>
        </div>
    </AppLayout>
</template>
