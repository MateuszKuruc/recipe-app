<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input'
import RecipeCard from '@/components/RecipeCard.vue';
import ActionCard from '@/components/ActionCard.vue';
import { Grid, Plus, Clock, Utensils, Hourglass } from 'lucide-vue-next';
import Paginator from '@/components/Paginator.vue';
import RecipeBadge from '@/components/RecipeBadge.vue';



defineProps({
    recipe: Object
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Recipes',
        href: '/recipes',
    }
];
</script>

<template>
    <Head title="Przepisy" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 rounded-xl p-4 max-w-[750px]">
            <div class="flex flex-col items-center border-b pb-8">
                <img :src="recipe.main_image" :alt="recipe.title">
            </div>

            <div class="flex flex-col gap-y-2">
                <div class="flex justify-between">
                    <h2 class="text-2xl font-bold">{{ recipe.title }}</h2>
                    <p>Opublikowano w <Link :href="route('categories.index')" class="text-blue-500 hover:text-blue-600 hover:underline">{{ recipe.category.name }}</Link></p>
                </div>
                <RecipeBadge :tags="recipe.tags" />
                    <p>{{ recipe.excerpt }}</p>
            </div>

            <div class="grid grid-cols-3 border p-6 max-w-[600px] rounded-xl">
                <div class="flex flex-col gap-4 items-center">
                    <div class="flex gap-2 items-center">
                        <Utensils />
                        <span class="text-lg">Porcja</span>
                    </div>
                    dla {{ recipe.servings }} osób
                </div>

                <div class="flex flex-col gap-4 items-center">
                    <div class="flex gap-2 items-center">
                        <Hourglass />
                        <span class="text-lg">Przygotowanie</span>
                    </div>
                    {{ recipe.prepare_time }} minut
                </div>

                <div class="flex flex-col gap-4 items-center">
                    <div class="flex gap-2 items-center">
                        <Clock />
                        <span class="text-lg">Gotowanie</span>
                    </div>
                    {{ recipe.cooking_time }} minut
                </div>
            </div>

            <div class="grid grid-cols-4 border max-w-[600px] rounded-xl text-center">
                <a href="#" class="p-4 border-r">Składniki</a>
                <a href="#" class="p-4 border-r">Instrukcje</a>
                <a href="#" class="p-4 border-r">Uwagi</a>
                <a href="#" class="p-4">Inspiracje</a>
            </div>

            <div class="flex flex-col gap-y-2">
                <h2 class="border-b pb-2">Składniki</h2>
                <p>{{ recipe.ingredients}}</p>
            </div>

            <div class="flex flex-col gap-y-2">
                <h2 class="border-b pb-2">Przygotowanie</h2>
                <p class="whitespace-pre-line leading-loose text-gray-700">{{ recipe.instructions}}</p>
            </div>

            <div class="flex flex-col gap-y-2">
                <h2 class="border-b pb-2">Propozycja podania</h2>
                <p>{{ recipe.ingredients}}</p>
            </div>

            <div>
                <img :src="recipe.secondary_image" alt="">
            </div>


        </div>
    </AppLayout>
</template>
