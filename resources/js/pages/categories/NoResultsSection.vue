<script setup lang="ts">
import LinkButton from '@/components/LinkButton.vue';
const props = defineProps<{
    displayData: boolean;
    buttonLabel?: string;
    buttonUrl?: string;
}>();
</script>

<template>
    <div v-if="displayData" class="mt-2 flex flex-col items-center gap-4 lg:items-start">
        <p class="text-xl">Brak przepisów w tej kategorii.</p>
        <div class="flex flex-col gap-2">
            <LinkButton :href="route('recipes.create')"> Dodaj nowy przepis</LinkButton>
            <LinkButton v-if="buttonLabel && buttonUrl" :href="route('categories.index')" variant="outline"> {{ buttonLabel }}</LinkButton>
        </div>
    </div>
</template>
