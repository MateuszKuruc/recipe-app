<script setup lang="ts">
import ActionCard from '@/components/ActionCard.vue';
import RecipeCarouselItem from '@/components/RecipeCarouselItem.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Autoplay from 'embla-carousel-autoplay';
import { Grid } from 'lucide-vue-next';

defineProps({
    categories: Array,
    totalRecipes: Number,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kategorie',
        href: '/kategorie',
    },
];
</script>

<template>
    <Head title="Kategorie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-auto mt-16 flex h-full max-w-[1440px] flex-1 flex-col gap-8 rounded-xl p-4">
            <div class="flex flex-col items-center gap-4 border-b pb-6">
                <h1 class="text-4xl font-bold">Kolekcja przepisów</h1>
                <p class="paragraph max-w-[60ch] text-center">
                    Sprawdź wybrane kategorie lub poszukaj inspiracji dzięki lo sowym przepisom z każdej kategoriisowym przepisom z każdej
                    kategoriisowym przepisom z każdej kategoriisowym przepisom z każdej kategoriisowym przepisom z każdej kategorii
                </p>
            </div>

            <div class="relative w-full overflow-visible px-4">
                <Carousel orientation="horizontal" class="mx-auto w-full" :opts="{ loop: true }" :plugins="[Autoplay({ delay: 2000 })]">
                    <CarouselContent>
                        <CarouselItem>
                            <RecipeCarouselItem
                                title="Jajeczniczka z boczkiem"
                                image="/storage/recipes/dDVVzefnoM4XilQVgiQ7psfJB8NaYVSYg2uFxsVx.png"
                                excerpt="uabubuasf wqewqewqks dahwqeoihwqsda sdaasjkhqwsa dashjsadkw"
                                link="/recipes"
                            />
                        </CarouselItem>
                    </CarouselContent>

                    <!-- Make arrows absolutely positioned -->
                    <CarouselPrevious class="absolute top-1/2 left-0 z-10 -translate-y-1/2" />
                    <CarouselNext class="absolute top-1/2 right-0 z-10 -translate-y-1/2" />
                </Carousel>
            </div>

            <div class="flex flex-col items-center gap-8 py-16">
                <div class="flex w-full flex-col items-center gap-4 border-b pb-6">
                    <h1 class="text-4xl font-bold">Kolekcja przepisów</h1>
                    <p class="paragraph max-w-[60ch] text-center">
                        Sprawdź wybrane kategorie lub poszukaj inspiracji dzięki lo sowym przepisom z każdej kategoriisowym przepisom z każdej
                        kategoriisowym przepisom z każdej kategoriisowym przepisom z każdej kategoriisowym przepisom z każdej kategorii
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 xl:grid-cols-2 2xl:grid-cols-3">
                    <div v-for="category in categories" :key="category.slug" class="aspect-[4/3] w-full">
                        <ActionCard
                            class="h-full w-full"
                            :title="category.name"
                            :image="category.image"
                            :href="route('categories.show', category.slug)"
                            :random-href="route('categories.random', category.slug)"
                            :count="category.recipes_count"
                        />
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <h2 class="border-b pt-6 pb-6 text-3xl font-bold">Sprawdź też:</h2>
                <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                    <ActionCard title="Wszystkie przepisy" :icon="Grid" :href="route('recipes.index')" :count="totalRecipes" />
                    <ActionCard title="Najnowsze przepisy" :icon="Grid" href="" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
