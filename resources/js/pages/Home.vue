<script setup lang="ts">
import RecipeCarouselItem from '@/components/RecipeCarouselItem.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import Autoplay from 'embla-carousel-autoplay';
import RecipeCardBlock from '@/components/RecipeCardBlock.vue';
import LinkButton from '@/components/LinkButton.vue';

defineProps({
    newestRecipes: Array
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Strona główna',
        href: '/',
    },
];

const autoplay = Autoplay({ delay: 2000, stopOnInteraction: false });

const user = usePage().props.auth.user;
</script>

<template>
    <Head title="Recipe App" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-8 p-4">
            <div class="w-full relative overflow-visible px-4">
                <Carousel
                    orientation="horizontal"
                    class="w-full max-w-6xl mx-auto"
                    :opts="{ loop: true }"
                    :plugins="[autoplay]"
                >
                    <CarouselContent>
                        <CarouselItem v-for="newRecipe in newestRecipes" :key="newRecipe.id">
                            <RecipeCarouselItem
                                :title="newRecipe.title"
                                :image="`/storage/${newRecipe.main_image}`"
                                :excerpt="newRecipe.excerpt"
                                :link="route('recipes.show', newRecipe.slug)"
                            />
                        </CarouselItem>
                    </CarouselContent>

                    <!-- Make arrows absolutely positioned -->
                    <CarouselPrevious @click="autoplay.reset()" class="absolute left-0 top-1/2 -translate-y-1/2 z-10" />
                    <CarouselNext @click="autoplay.reset()" class="absolute right-0 top-1/2 -translate-y-1/2 z-10" />
                </Carousel>
            </div>


            <!-- Latest Recipes Section -->
            <section class="w-full max-w-6xl mx-auto px-4">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4 sm:gap-0">
                    <h2 class="text-3xl font-extrabold">Latest Recipes</h2>
                    <LinkButton
                        href="/recipes"
                        class="border px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition"
                    >
                        Browse All
                    </LinkButton>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <RecipeCardBlock
                        image="/storage/recipes/sandwich.jpg"
                        title="Tenetur officia animi voluptates ab ut."
                        subtitle="Category title"
                    />
                    <RecipeCardBlock
                        image="/storage/recipes/wings.jpg"
                        title="Eos nemo laboriosam dolores possimus eaque enim."
                        subtitle="Category title"
                    />
                    <RecipeCardBlock
                        image="/storage/recipes/pita.jpg"
                        title="Quia aliquam recusandae repellendus veritatis vitae atque voluptas."
                        subtitle="Category title"
                    />
                    <RecipeCardBlock
                        image="/storage/recipes/wings.jpg"
                        title="Saepe odit qui expedita voluptatum et aut optio."
                        subtitle="Category title"
                    />
                </div>
            </section>
        </div>
    </AppLayout>
</template>

