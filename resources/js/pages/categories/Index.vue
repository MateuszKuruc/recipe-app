<script setup lang="ts">
import ActionCard from '@/components/ActionCard.vue';
import RecipeCarouselItem from '@/components/RecipeCarouselItem.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Autoplay from 'embla-carousel-autoplay';
import { Gift, Grid } from 'lucide-vue-next';

defineProps({
    categories: Array,
    totalRecipes: Number,
    randomRecipes: Array
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kategorie',
        href: '/kategorie',
    },
];

const autoplay = Autoplay({ delay: 2000, stopOnInteraction: false });
</script>

<template>
    <Head title="Kategorie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mt-16 flex h-full max-w-[1440px] flex-1 flex-col gap-8 rounded-xl p-4 items-center self-center">
            <div class="flex flex-col items-center gap-4 border-b pb-6">
                <h1 class="text-4xl font-bold text-center">Kolekcja przepisów</h1>
                <p class="paragraph max-w-[60ch] text-center">
                    Przeglądaj przepisy według kategorii i odkrywaj nowe pomysły na śniadania, obiady, desery i wiele więcej.
                </p>
            </div>

            <div v-if="randomRecipes.length" class="relative w-full overflow-visible px-4">
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

                    <CarouselPrevious @click="autoplay.reset()" class="absolute top-1/2 left-3 xl:left-10 z-10 -translate-y-1/2 bg-transparent xl:bg-rose-700 text-white hover:bg-rose-600 hover:text-white" />
                    <CarouselNext @click="autoplay.reset()" class="absolute top-1/2 right-3 xl:right-10 z-10 -translate-y-1/2 bg-transparent xl:bg-rose-700 text-white hover:bg-rose-600 hover:text-white" />
                </Carousel>
            </div>

            <div class="flex flex-col items-center gap-8 py-16">
                <div class="flex w-full flex-col items-center gap-4 border-b pb-6">
                    <h1 class="text-4xl font-bold text-center">Brak pomysłu na jedzenie?</h1>
                    <p class="paragraph max-w-[60ch] text-center">
                        Wybierz kategorię, która Cię interesuje i poszukaj inspiracji lub oddaj decyzję w ręce losu i wybierz przepis niespodziankę z dowolnej kategorii
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 2xl:grid-cols-3 w-full">
                    <div v-for="category in categories" :key="category.slug" class="aspect-[4/3] h-60 w-full">
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

            <div class="space-y-8 w-full">
                <h2 class="border-b pt-6 pb-6 text-3xl font-bold text-center">Sprawdź też:</h2>
                <div class="flex flex-col gap-4">
                    <ActionCard
                        title="Wszystkie przepisy"
                        :icon="Grid"
                        :href="route('recipes.index')"
                        :count="totalRecipes"
                        class="h-[200px] w-full"
                    />
                    <ActionCard title="Wylosuj przepis" :icon="Gift" :href="route('recipes.random')" class="h-42 w-full" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
