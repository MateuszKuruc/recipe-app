<script setup lang="ts">
import RecipeBadge from '@/components/RecipeBadge.vue';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Clock, Heart, Hourglass, Utensils } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

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

const form = useForm({});
const page = usePage();

const authUser = page.props.auth?.user;
const recipe = ref({ ...page.props.recipe });

const favoritedBy = ref(recipe.value.favorited_by || null);

const isFavorited = computed(() => {
    return authUser && favoritedBy.value.some((user) => user.id === authUser.id);
});

const toggleFavorite = () => {
    if (!authUser || form.processing) return;

    const userId = authUser.id;

    if (isFavorited.value) {
        favoritedBy.value = favoritedBy.value.filter((u) => u.id !== userId);

        form.delete(route('recipes.unfavorite', recipe.value.slug), {
            preserveScroll: true,
            onSuccess: () => {
                toast.info('Przepis usunięty z ulubionych');
            },
            onError: () => {
                favoritedBy.value.push(authUser);
                toast.error('Nie udało się usunąć z ulubionych');
            },
        });
    } else {
        favoritedBy.value.push(authUser);

        form.post(route('recipes.favorite', recipe.value.slug), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Przepis dodany do ulubionych');
            },
            onError: () => {
                favoritedBy.value = favoritedBy.value.filter((user) => user.id !== authUser.id);
                toast.error('Nie udało się dodać przepisu do ulubionych');
            },
        });
    }
};

const deleteRecipe = () => {
    form.delete(route('recipes.destroy', recipe.value.slug), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Przepis został usunięty');
        },
        onError: () => {
            toast.error('Wystąpił błąd, przepis nie został usunięty');
        },
    });
};
</script>

<template>
    <Head :title="recipe.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 overflow-hidden rounded-xl p-4">
            <div class="flex flex-col items-center border-b pb-8">
                <img :src="`/storage/${recipe.main_image}`" :alt="recipe.title" />
            </div>

            <div class="grid grid-cols-1 gap-8 2xl:grid-cols-[1fr_400px]">
                <div class="max-w-[700px] pb-16 md:mx-auto md:pb-16">
                    <div class="flex flex-col gap-y-6 md:gap-y-4">
                        <div class="flex items-center justify-between">
                            <p>
                                Kategoria:
                                <Link :href="route('categories.index')" class="text-rose-600 hover:text-rose-500 hover:underline"
                                    >{{ recipe.category.name }}
                                </Link>
                            </p>
                            <Button
                                v-if="authUser"
                                :disabled="form.processing"
                                class="rounded-xl border border-gray-300 hover:cursor-pointer"
                                variant="outline"
                                @click="toggleFavorite"
                                :aria-label="isFavorited ? 'Usuń z ulubionych' : 'Dodaj do ulubionych'"
                            >
                                <Heart :class="isFavorited ? 'fill-rose-600' : 'stroke-current'" />
                            </Button>
                        </div>

                        <h2 class="max-w-full text-4xl font-bold break-words text-rose-600">{{ recipe.title }}</h2>

                        <RecipeBadge :tags="recipe.tags" />
                        <p class="paragraph pt-2">{{ recipe.excerpt }}</p>
                    </div>

                    <div class="my-8 flex flex-col gap-6 rounded-xl border border-gray-300 p-6 md:grid md:grid-cols-3">
                        <div class="flex flex-col items-center gap-2 md:gap-4">
                            <div class="flex items-center gap-2">
                                <Utensils />
                                <span class="text-lg">Porcja</span>
                            </div>
                            dla {{ recipe.servings }} osób
                        </div>

                        <div class="flex flex-col items-center gap-2 md:gap-4">
                            <div class="flex items-center gap-2">
                                <Hourglass />
                                <span class="text-lg">Przygotowanie</span>
                            </div>
                            {{ recipe.prepare_time }} minut
                        </div>

                        <div class="flex flex-col items-center gap-2 md:gap-4">
                            <div class="flex items-center gap-2">
                                <Clock />
                                <span class="text-lg">Gotowanie</span>
                            </div>
                            {{ recipe.cooking_time }} minut
                        </div>
                    </div>

                    <div class="mb-16 grid grid-cols-2 overflow-hidden rounded-xl border border-gray-300 text-center md:grid-cols-4">
                        <a href="#skladniki" class="border-r p-4 hover:bg-sidebar-accent">Składniki</a>
                        <a href="#przygotowanie" class="border-r p-4 hover:bg-primary/60">Przygotowanie</a>
                        <a href="#uwagi" class="border-r p-4 hover:bg-primary/60">Uwagi</a>
                        <a href="#inspiracje" class="p-4 hover:bg-primary/60">Inspiracje</a>
                    </div>

                    <div class="flex flex-col gap-16 space-y-8">
                        <div class="flex flex-col gap-y-2" id="skladniki">
                            <h2 class="border-b pb-2 text-3xl font-bold">Składniki</h2>
                            <p class="paragraph">{{ recipe.ingredients }}</p>
                        </div>

                        <div class="flex flex-col gap-y-2">
                            <h2 class="border-b pb-2 text-3xl font-bold" id="przygotowanie">Przygotowanie</h2>
                            <p class="paragraph">{{ recipe.instructions }}</p>
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
                <!-- Right sidebar -->
                <div class="mx-auto max-w-[700px] border-gray-300 2xl:border-l 2xl:pl-8">
                    <aside class="w-full space-y-8">
                        <!-- Edit Recipe -->
                        <div class="flex flex-col gap-3">
                            <Link v-if="authUser && recipe.user_id === authUser.id" :href="route('recipes.edit', recipe.slug)">
                                <Button class="w-[150px] bg-teal-600 hover:bg-teal-500" type="button" variant="default">Edytuj przepis</Button>
                            </Link>

                            <AlertDialog v-if="authUser && recipe.user_id === authUser.id">
                                <AlertDialogTrigger as-child>
                                    <Button variant="destructive" type="button" class="w-[150px]"> Usuń przepis </Button>
                                </AlertDialogTrigger>
                                <AlertDialogContent>
                                    <AlertDialogHeader>
                                        <AlertDialogTitle>Na pewno chcesz usunąć przepis?</AlertDialogTitle>
                                        <AlertDialogDescription>
                                            Ta akcja jest nieodwracalna. Twój przepis zostanie permanentnie usunięty z bazy danych.
                                        </AlertDialogDescription>
                                    </AlertDialogHeader>
                                    <AlertDialogFooter>
                                        <AlertDialogCancel>Anuluj</AlertDialogCancel>

                                        <AlertDialogAction class="bg-destructive hover:bg-destructive/90" @click="deleteRecipe"
                                            >Potwierdź</AlertDialogAction
                                        >
                                    </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
                        </div>

                        <!-- Categories -->
                        <div>
                            <h3 class="mb-3 border-b border-gray-300 pb-3 text-2xl font-semibold">Kategorie</h3>
                            <ul class="space-y-1 text-sm">
                                <li v-for="category in categories" :key="category.id">
                                    <Link :href="route('categories.show', category.slug)" class="text-gray-700 hover:text-rose-600 hover:underline">
                                        {{ category.name }} <span class="text-gray-400">({{ category.recipes_count }})</span>
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        <!-- Related Recipes -->
                        <div>
                            <h3 class="mb-3 border-b border-gray-300 pb-3 text-2xl font-semibold">Podobne przepisy</h3>
                            <ul class="flex flex-col space-y-8">
                                <li v-for="recipe in relatedRecipes" :key="recipe.id" class="space-y-3">
                                    <img :src="`/storage/${recipe.main_image}`" :alt="recipe.title" class="h-full w-full rounded-xl border object-cover" />
                                    <Link :href="route('recipes.show', recipe.slug)" class="text-2xl text-rose-600 hover:text-rose-500">
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
