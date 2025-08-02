<script setup lang="ts">

import AuthBase from '@/layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import RecipeForm from '@/components/RecipeForm.vue';
import type { BreadcrumbItem } from '@/types';

const props = defineProps({
    categories: Array,
    tags: Array,
    recipe: Object
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Przepisy',
        href: route('recipes.index'),
    },
    {
        title: props.recipe.title,
        href: `/przepisy/${props.recipe.slug}`,
    },
    {
        title: 'Edytuj przepis',
        href: `/przepisy/${props.recipe.slug}/edit`,
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <AuthBase title="Edytuj swój przepis" description="Uzupełnij wymagane pola i zaktualizuj swój przepis!">
            <Head title="Edytuj przepis" />
            <RecipeForm :categories="categories" :tags="tags" :recipe="recipe" />

        </AuthBase>
    </AppLayout>
</template>
