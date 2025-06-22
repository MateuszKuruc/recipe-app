<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
const { recipes } = defineProps({
    recipes: Object
})

const prevLink = computed(() => recipes.links[0])
const nextLink = computed(() => recipes.links[recipes.links.length - 1]);
const pageLinks = computed(() => recipes.links.slice(1, recipes.links.length -1));
</script>

<template>
    <div class="flex justify-center gap-1 mt-4 flex-wrap">
        <!-- Previous -->
        <Link
            :href="prevLink.url || ''"
            :class="[
        'px-3 py-1 border rounded text-sm',
        prevLink.url
          ? 'bg-white text-gray-700 hover:bg-gray-100'
          : 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none'
      ]"
            v-html="'&laquo; Poprzednia'"

        />

        <!-- Pages -->
        <Link
            v-for="link in pageLinks"
            :key="link.label + link.url"
            :href="link.url || ''"
            :class="[
        'px-3 py-1 border rounded text-sm',
        link.active
          ? 'bg-blue-500 text-white'
          : 'bg-white text-gray-700 hover:bg-gray-100'
      ]"
            v-html="link.label"
        />

        <!-- Next -->
        <Link
            :href="nextLink.url || ''"
            :class="[
        'px-3 py-1 border rounded text-sm',
        nextLink.url
          ? 'bg-white text-gray-700 hover:bg-gray-100'
          : 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none'
      ]"
            v-html="'Następna &raquo;'"
        />
    </div>
</template>
