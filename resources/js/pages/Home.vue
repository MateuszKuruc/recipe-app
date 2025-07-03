<script setup lang="ts">
import RecipeCarouselItem from '@/components/RecipeCarouselItem.vue';
import RecipeSection from '@/components/RecipeSection.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Autoplay from 'embla-carousel-autoplay';
import LinkButton from '@/components/LinkButton.vue';
import { Gift, Plus, Scroll } from 'lucide-vue-next';
import ActionCard from '@/components/ActionCard.vue';

const props = defineProps({
    newestRecipes: Array,
    randomRecipes: Array,
    favoriteRecipes: {
        type: Array,
        default: null,
    },
    breakfastRecipes: Array,
    dinnerRecipes: Array,
    dessertRecipes: Array,
});

const { favoriteRecipes, newestRecipes, breakfastRecipes, dinnerRecipes, dessertRecipes } = props;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Strona główna',
        href: '/',
    },
];

const autoplay = Autoplay({ delay: 2000, stopOnInteraction: false });

const sections = [
    favoriteRecipes && {
        label: 'Twoje ulubione przepisy',
        data: favoriteRecipes,
        buttonLabel: 'Wszystkie ulubione przepisy',
        href: route('recipes.favorites'),
        isCategory: false,
    },
    {
        label: 'Najnowsze przepisy',
        data: newestRecipes,
        buttonLabel: 'Wszystkie przepisy',
        href: route('recipes.index'),
        isCategory: false,
    },
    {
        label: 'śniadania',
        data: breakfastRecipes,
        buttonLabel: 'Wszystkie śniadania',
        href: route('categories.show', 'sniadania'),
        isCategory: true,
    },
    {
        label: 'dania główne',
        data: dinnerRecipes,
        buttonLabel: 'Wszystkie dania główne',
        href: route('categories.show', 'dania-glowne'),
        isCategory: true,
    },
    {
        label: 'desery',
        data: dessertRecipes,
        buttonLabel: 'Wszystkie desery',
        href: route('categories.show', 'desery'),
        isCategory: true,
    },
].filter(Boolean);
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
                <RecipeSection
                    v-for="section in sections"
                    :label="section.label"
                    :button-label="section.buttonLabel"
                    :data="section.data"
                    :href="section.href"
                    :is-category="section.isCategory"
                />
            </div>

            <div class="flex flex-col items-center py-8">
                <LinkButton :href="route('categories.index')" class="max-w-[300px] py-4 px-8">
                    Zobacz wszystkie kategorie
                </LinkButton>
            </div>

            <div class="grid gap-4 xl:grid-cols-3">
                <ActionCard title="Dodaj nowy przepis" :icon="Plus" :href="route('recipes.create')" class="h-42 w-full" />
                <ActionCard title="Wszystkie przepisy" :icon="Scroll" :href="route('recipes.index')" class="h-42 w-full" />
                <ActionCard title="Wylosuj przepis" :icon="Gift" :href="route('recipes.random')" class="h-42 w-full" />
            </div>
        </div>
    </AppLayout>
</template>
