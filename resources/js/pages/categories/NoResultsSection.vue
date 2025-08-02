<script setup lang="ts">
import LinkButton from '@/components/LinkButton.vue';
const props = defineProps<{
    displayData: boolean;
    buttonLabel?: string;
    buttonUrl?: string;
}>();
</script>

<template>
    <div v-if="displayData" class="mt-2 flex flex-col items-start gap-4">
        <p class="text-xl">Brak przepisów w tej kategorii.</p>
        <div class="flex gap-2">
            <LinkButton :href="route('recipes.create')"> Dodaj nowy przepis</LinkButton>
            <LinkButton v-if="buttonLabel && buttonUrl" :href="route('categories.index')" variant="outline"> {{ buttonLabel }}</LinkButton>
        </div>
    </div>
</template>
