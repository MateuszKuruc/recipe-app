<script setup lang="ts">
defineProps({
    tags: Array,
})

function badgeClass(name) {
    switch(name) {
        case 'Wegetariański': return 'bg-green-600';
        case 'Wysokobiałkowy': return 'bg-blue-500';
        case 'Ostry': return 'bg-red-500';
        case 'Słodki': return 'bg-pink-500';
        case 'Szybki': return 'bg-orange-500';
        case 'Czasochłonny': return 'bg-gray-500';
    }
}
</script>

<template>
    <div class="flex flex-wrap gap-2 mt-2">
        <span v-for="tag in tags" :key="tag.id" class="px-2 py-1 text-xs font-semibold rounded text-white" :class="badgeClass(tag.name)">
            {{ tag.name }}
        </span>
    </div>

</template>
