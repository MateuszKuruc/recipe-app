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
    categories: Array
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
                <ActionCard v-for="category in categories" :title="category.name" :icon="Grid" :href="route('home')" />
            </div>

            <div>
                <h2>Sprawdź też:</h2>
                <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                    <ActionCard title="Wszystkie przepisy" :icon="Grid" href="" />
                    <ActionCard title="Najnowsze przepisy" :icon="Grid" href="" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
