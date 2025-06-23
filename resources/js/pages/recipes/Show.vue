<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import RecipeCard from '@/components/RecipeCard.vue';
import ActionCard from '@/components/ActionCard.vue';
import { Grid, Plus, Clock, Utensils, Hourglass } from 'lucide-vue-next';
import Paginator from '@/components/Paginator.vue';
import RecipeBadge from '@/components/RecipeBadge.vue';

defineProps({
    recipe: Object,
    categories: Array,
    relatedRecipes: Array
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Recipes',
        href: '/recipes',
    },
];
</script>

<template>
    <Head :title="recipe.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 rounded-xl p-4">
            <div class="flex flex-col items-center border-b pb-8">
                <img :src="recipe.main_image" :alt="recipe.title" />
            </div>

            <div class="grid grid-cols-[1fr_400px] gap-20">
                <div class="max-w-[700px] m-auto">
                    <div class="flex flex-col gap-y-2">
                        <div class="flex justify-between">
                            <h2 class="text-2xl font-bold">{{ recipe.title }}</h2>
                            <p>
                                Opublikowano w
                                <Link :href="route('categories.index')" class="text-blue-500 hover:text-blue-600 hover:underline"
                                    >{{ recipe.category.name }}
                                </Link>
                            </p>
                        </div>
                        <RecipeBadge :tags="recipe.tags" />
                        <p class="paragraph">{{ recipe.excerpt }}</p>
                    </div>

                    <div class="grid grid-cols-3 rounded-xl border p-6 my-8">
                        <div class="flex flex-col items-center gap-4">
                            <div class="flex items-center gap-2">
                                <Utensils />
                                <span class="text-lg">Porcja</span>
                            </div>
                            dla {{ recipe.servings }} osób
                        </div>

                        <div class="flex flex-col items-center gap-4">
                            <div class="flex items-center gap-2">
                                <Hourglass />
                                <span class="text-lg">Przygotowanie</span>
                            </div>
                            {{ recipe.prepare_time }} minut
                        </div>

                        <div class="flex flex-col items-center gap-4">
                            <div class="flex items-center gap-2">
                                <Clock />
                                <span class="text-lg">Gotowanie</span>
                            </div>
                            {{ recipe.cooking_time }} minut
                        </div>
                    </div>

                    <div class="grid grid-cols-4 overflow-hidden rounded-xl border text-center mb-16">
                        <a href="#skladniki" class="border-r p-4 hover:bg-gray-50">Składniki</a>
                        <a href="#przygotowanie" class="border-r p-4 hover:bg-gray-50">Przygotowanie</a>
                        <a href="#uwagi" class="border-r p-4 hover:bg-gray-50">Uwagi</a>
                        <a href="#inspiracje" class="p-4 hover:bg-gray-50">Inspiracje</a>
                    </div>

                    <div class="flex flex-col gap-y-2" id="skladniki">
                        <h2 class="border-b pb-2">Składniki</h2>
                        <p class="paragraph">{{ recipe.ingredients }}</p>
                    </div>

                    <div class="flex flex-col gap-y-2">
                        <h2 class="border-b pb-2" id="przygotowanie">Przygotowanie</h2>
                        <p class="paragraph">{{ recipe.instructions }}</p>
                    </div>

                    <div class="flex flex-col gap-y-2">
                        <h2 class="border-b pb-2">Propozycja podania</h2>
                        <p class="paragraph">{{ recipe.ingredients }}</p>
                    </div>

                    <div class="flex flex-col gap-y-2" id="uwagi">
                        <h2 class="border-b pb-2">Uwagi</h2>
                        <p class="paragraph">{{ recipe.ingredients }}</p>
                    </div>

                    <div>
                        <img :src="recipe.secondary_image" alt="" />
                    </div>

                    <div class="flex flex-col gap-y-2" id="inspiracje">
                        <h2 class="border-b pb-2">Inspiracje</h2>
                        <p>{{ recipe.ingredients }}</p>
                    </div>
                </div>




                <div class="max-w-[400px]">


                    <aside class="hidden lg:block w-full space-y-8">
                        <!-- Categories -->
                        <div>
                            <h3 class="text-lg font-semibold border-b pb-1 mb-2">Kategorie</h3>
                            <ul class="space-y-1 text-sm">
                                <li v-for="category in categories" :key="category.id">
                                    <Link
                                      href="#"
                                        class="text-gray-700 hover:text-red-600 hover:underline"
                                    >
                                        {{ category.name }} <span class="text-gray-400">({{ category.recipes_count }})</span>
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        <!-- Related Recipes -->
                        <div>
                            <h3 class="text-lg font-semibold border-b pb-1 mb-2">Podobne przepisy</h3>
                            <ul class="space-y-8">
                                <li v-for="recipe in relatedRecipes" :key="recipe.id" class="space-y-3">
                                    <img
                                        :src="recipe.main_image"
                                        :alt="recipe.title"
                                        class="w-full h-full object-cover rounded-xl border"
                                    />
                                    <Link :href="route('recipes.show', recipe.slug)" class="text-lg text-gray-700 hover:text-red-600">
                                        {{ recipe.title }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </aside>




                </div>
            </div>
        </div>
    </AppLayout>
</template>
