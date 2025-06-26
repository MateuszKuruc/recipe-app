<script setup lang="ts">
import RecipeBadge from '@/components/RecipeBadge.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Clock, Hourglass, Utensils } from 'lucide-vue-next';
import { Button } from '@/components/ui/button'
import { usePage } from '@inertiajs/vue3';

defineProps({
    recipe: Object,
    categories: Array,
    relatedRecipes: Array,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Przepisy',
        href: '/przepisy',
    },
];

const page = usePage();
const authUser = page.props.auth?.user;
const recipe = page.props.recipe;
</script>

<template>
    <Head :title="recipe.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 rounded-xl p-4">
            <div class="flex flex-col items-center border-b pb-8">
                <img :src="`/storage/${recipe.main_image}`" :alt="recipe.title" />
            </div>

            <div class="md:grid xl:grid-cols-[1fr_400px] gap-20">
                <div class="m-auto max-w-[700px] pb-16 md:pb-16">
                    <div class="flex flex-col gap-y-2">
                        <p>
                            Kategoria:
                            <Link :href="route('categories.index')" class="text-blue-500 hover:text-blue-600 hover:underline"
                                >{{ recipe.category.name }}
                            </Link>
                        </p>
                        <h2 class="w-[600px] text-4xl font-bold text-red-500">{{ recipe.title }}</h2>

                        <RecipeBadge :tags="recipe.tags" />
                        <p class="paragraph pt-2">{{ recipe.excerpt }}</p>
                    </div>

                    <div class="my-8 grid grid-cols-3 rounded-xl border p-6">
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

                    <div class="mb-16 grid grid-cols-4 overflow-hidden rounded-xl border text-center">
                        <a href="#skladniki" class="border-r p-4 hover:bg-gray-50">Składniki</a>
                        <a href="#przygotowanie" class="border-r p-4 hover:bg-gray-50">Przygotowanie</a>
                        <a href="#uwagi" class="border-r p-4 hover:bg-gray-50">Uwagi</a>
                        <a href="#inspiracje" class="p-4 hover:bg-gray-50">Inspiracje</a>
                    </div>
                    <div class="space-y-8">
                        <div class="flex flex-col gap-y-2" id="skladniki">
                            <h2 class="border-b pb-2 text-3xl font-bold">Składniki</h2>
                            <p class="paragraph">{{ recipe.ingredients }}</p>
                        </div>

                        <div class="flex flex-col gap-y-2">
                            <h2 class="border-b pb-2 text-3xl font-bold" id="przygotowanie">Przygotowanie</h2>
                            <p class="paragraph">{{ recipe.instructions }}</p>
                        </div>

                        <div class="flex flex-col gap-y-2">
                            <h2 class="border-b pb-2 text-3xl font-bold">Propozycja podania</h2>
                            <p class="paragraph">{{ recipe.ingredients }}</p>
                        </div>

                        <div class="flex flex-col gap-y-2" id="uwagi">
                            <h2 class="border-b pb-2 text-3xl font-bold">Uwagi</h2>
                            <p class="paragraph">{{ recipe.ingredients }}</p>
                        </div>

                        <div v-if="recipe.secondary_image">
                            <img :src="`/storage/${recipe.secondary_image}`" alt="" />
                        </div>

                        <div class="flex flex-col gap-y-2" id="inspiracje">
                            <h2 class="border-b pb-2 text-3xl font-bold">Inspiracje</h2>
                            <p>{{ recipe.ingredients }}</p>
                        </div>
                    </div>
                </div>

                <div class="xl:max-w-[400px] max-w-[80%]">
                    <aside class="w-full space-y-8">
                        <!-- Edit Recipe -->
                        <Link v-if="authUser && recipe.user_id === authUser.id" :href="route('recipes.edit', recipe.slug)">
                            <Button >Edytuj przepis</Button>
                        </Link>


                        <!-- Categories -->
                        <div>
                            <h3 class="mb-2 border-b pb-1 text-lg font-semibold">Kategorie</h3>
                            <ul class="space-y-1 text-sm">
                                <li v-for="category in categories" :key="category.id">
                                    <Link :href="route('categories.show', category.slug)" class="text-gray-700 hover:text-red-600 hover:underline">
                                        {{ category.name }} <span class="text-gray-400">({{ category.recipes_count }})</span>
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        <!-- Related Recipes -->
                        <div>
                            <h3 class="mb-2 border-b pb-1 text-lg font-semibold">Podobne przepisy</h3>
                            <ul class="space-y-8 flex flex-col ">
                                <li v-for="recipe in relatedRecipes" :key="recipe.id" class="space-y-3">
                                    <img :src="recipe.main_image" :alt="recipe.title" class="h-full w-full rounded-xl border object-cover" />
                                    <Link :href="route('recipes.show', recipe.slug)" class="text-2xl text-red-500 hover:text-red-600">
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
