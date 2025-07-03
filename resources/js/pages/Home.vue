<script setup lang="ts">
import LinkButton from '@/components/LinkButton.vue';
import RecipeCardBlock from '@/components/RecipeCardBlock.vue';
import RecipeCarouselItem from '@/components/RecipeCarouselItem.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Autoplay from 'embla-carousel-autoplay';

const props = defineProps({
    newestRecipes: Array,
    randomRecipes: Array,
    favoriteRecipes: {
        type: Array,
        default: null,
    },
    breakfastRecipes: Array,
    dinnerRecipes: Array,
    dessertRecipes: Array
});

const {
    favoriteRecipes,
    newestRecipes,
    breakfastRecipes,
    dinnerRecipes,
    dessertRecipes
} = props;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Strona główna',
        href: '/',
    },
];

const autoplay = Autoplay({ delay: 2000, stopOnInteraction: false });

const sections = [
    {
        label: 'Twoje ulubione przepisy',
        data: favoriteRecipes,
        buttonLabel: 'Wszystkie ulubione przepisy',
        href: route('recipes.favorites')
    },
    {
        label: 'Najnowsze przepisy',
        data: newestRecipes,
        buttonLabel: 'Wszystkie przepisy',
        href: route('recipes.index')
    },
]
</script>

<template>
    <Head title="Recipe App" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-8 p-4">
            <div class="relative w-full overflow-visible px-4">
                <Carousel orientation="horizontal" class="mx-auto w-full max-w-6xl" :opts="{ loop: true }" :plugins="[autoplay]">
                    <CarouselContent>
                        <CarouselItem v-for="randomRecipe in randomRecipes" :key="randomRecipe.id">
                            <RecipeCarouselItem
                                :title="randomRecipe.title"
                                :image="`/storage/${randomRecipe.main_image}`"
                                :excerpt="randomRecipe.excerpt"
                                :link="route('recipes.show', randomRecipe.slug)"
                            />
                        </CarouselItem>
                    </CarouselContent>

                    <CarouselPrevious @click="autoplay.reset()" class="absolute top-1/2 left-0 z-10 -translate-y-1/2" />
                    <CarouselNext @click="autoplay.reset()" class="absolute top-1/2 right-0 z-10 -translate-y-1/2" />
                </Carousel>
            </div>

            <div class="flex flex-col gap-32">
                <!-- Favorite Recipes Section -->
                <section v-for="section in sections" :key="section.label" class="mx-auto w-full max-w-6xl px-4">
                    <div class="mb-8 flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-0 border-b border-gray-300 pb-4">
                        <h2 class="text-3xl font-extrabold">{{ section.label }}</h2>
                        <LinkButton
                            :href="section.href"
                            class="rounded-md border px-4 py-2 text-sm font-medium transition hover:bg-gray-100"
                        >
                            {{ section.buttonLabel }}
                        </LinkButton>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <RecipeCardBlock
                            v-for="recipe in section.data"
                            :key="recipe.id"
                            :image="`/storage/${recipe.main_image}`"
                            :title="recipe.title"
                            :href="route('recipes.show', recipe.slug)"
                        />
                    </div>
                </section>

<!--                &lt;!&ndash; Latest Recipes Section &ndash;&gt;-->
<!--                <section class="mx-auto w-full max-w-6xl px-4">-->
<!--                    <div class="mb-8 flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-0 border-b border-gray-300 pb-4">-->
<!--                        <h2 class="text-3xl font-extrabold">Najnowsze przepisy</h2>-->
<!--                        <LinkButton-->
<!--                            :href="route('recipes.index')"-->
<!--                            class="rounded-md border px-4 py-2 text-sm font-medium transition hover:bg-gray-100"-->
<!--                        >-->
<!--                            Przeglądaj wszystkie-->
<!--                        </LinkButton>-->
<!--                    </div>-->

<!--                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">-->
<!--                        <RecipeCardBlock-->
<!--                            v-for="newRecipe in newestRecipes"-->
<!--                            :key="newRecipe.id"-->
<!--                            :image="`/storage/${newRecipe.main_image}`"-->
<!--                            :title="newRecipe.title"-->
<!--                            :href="route('recipes.show', newRecipe.slug)"-->
<!--                        />-->
<!--                    </div>-->
<!--                </section>-->

<!--                &lt;!&ndash; Breakfast Recipes Section &ndash;&gt;-->
<!--                <section class="mx-auto w-full max-w-6xl px-4">-->
<!--                    <div class="mb-8 flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-0 border-b border-gray-300 pb-4">-->
<!--                        <h2 class="text-3xl font-extrabold">Kategoria: <span class="text-orange-500">Śniadania</span></h2>-->
<!--                        <LinkButton-->
<!--                            :href="route('categories.show', 'sniadania')"-->
<!--                            class="rounded-md border px-4 py-2 text-sm font-medium transition hover:bg-gray-100"-->
<!--                        >-->
<!--                            Wszystkie śniadania-->
<!--                        </LinkButton>-->
<!--                    </div>-->

<!--                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">-->
<!--                        <RecipeCardBlock-->
<!--                            v-for="breakfastRecipe in breakfastRecipes"-->
<!--                            :key="breakfastRecipe.id"-->
<!--                            :image="`/storage/${breakfastRecipe.main_image}`"-->
<!--                            :title="breakfastRecipe.title"-->
<!--                            :href="route('recipes.show', breakfastRecipe.slug)"-->
<!--                        />-->
<!--                    </div>-->
<!--                </section>-->

<!--                &lt;!&ndash; Dinner Recipes Section &ndash;&gt;-->
<!--                <section class="mx-auto w-full max-w-6xl px-4">-->
<!--                    <div class="mb-8 flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-0 border-b border-gray-300 pb-4">-->
<!--                        <h2 class="text-3xl font-extrabold">Kategoria: <span class="text-orange-500">Dania główne</span></h2>-->
<!--                        <LinkButton-->
<!--                            :href="route('categories.show', 'dania-glowne')"-->
<!--                            class="rounded-md border px-4 py-2 text-sm font-medium transition hover:bg-gray-100"-->
<!--                        >-->
<!--                            Wszystkie dania główne-->
<!--                        </LinkButton>-->
<!--                    </div>-->

<!--                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">-->
<!--                        <RecipeCardBlock-->
<!--                            v-for="dinnerRecipe in dinnerRecipes"-->
<!--                            :key="dinnerRecipe.id"-->
<!--                            :image="`/storage/${dinnerRecipe.main_image}`"-->
<!--                            :title="dinnerRecipe.title"-->
<!--                            :href="route('recipes.show', dinnerRecipe.slug)"-->
<!--                        />-->
<!--                    </div>-->
<!--                </section>-->

<!--                &lt;!&ndash; Dessert Recipes Section &ndash;&gt;-->
<!--                <section class="mx-auto w-full max-w-6xl px-4">-->
<!--                    <div class="mb-8 flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-0 border-b border-gray-300 pb-4">-->
<!--                        <h2 class="text-3xl font-extrabold">Kategoria: <span class="text-orange-500">Desery</span></h2>-->
<!--                        <LinkButton-->
<!--                            :href="route('categories.show', 'desery')"-->
<!--                            class="rounded-md border px-4 py-2 text-sm font-medium transition hover:bg-gray-100"-->
<!--                        >-->
<!--                            Wszystkie desery-->
<!--                        </LinkButton>-->
<!--                    </div>-->

<!--                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">-->
<!--                        <RecipeCardBlock-->
<!--                            v-for="dessertRecipe in dessertRecipes"-->
<!--                            :key="dessertRecipe.id"-->
<!--                            :image="`/storage/${dessertRecipe.main_image}`"-->
<!--                            :title="dessertRecipe.title"-->
<!--                            :href="route('recipes.show', dessertRecipe.slug)"-->
<!--                        />-->
<!--                    </div>-->
<!--                </section>-->
            </div>
        </div>
    </AppLayout>
</template>
