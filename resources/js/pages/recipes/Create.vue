<script setup lang="ts">

import AuthBase from '@/layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import RecipeForm from '@/components/RecipeForm.vue';
import { type BreadcrumbItem } from '@/types';

defineProps({
    categories: Array,
    tags: Array,
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Nowy przepis',
        href: '/kategorie',
    },
];

</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <AuthBase title="Dodaj nowy przepis" description="Uzupełnij wymagane pola i zapisz swój przepis!">
            <Head title="Nowy przepis" />
                <RecipeForm :categories="categories" :tags="tags" />
        </AuthBase>
    </AppLayout>
</template>
