<script setup lang="ts">

import AuthBase from '@/layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import RecipeForm from '@/components/RecipeForm.vue';

defineProps({
    categories: Array,
    tags: Array,
    recipe: Object
})

</script>

<template>
    <AppLayout>
        <AuthBase title="Edytuj swój przepis" description="Uzupełnij wymagane pola i zaktualizuj swój przepis!">
            <Head title="Edytuj przepis" />
            <RecipeForm :categories="categories" :tags="tags" :recipe="recipe" />

        </AuthBase>
    </AppLayout>
</template>
