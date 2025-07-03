<script setup lang="ts">
import { Candy, Dumbbell, Flame, Hourglass, Leaf, Tag, Zap } from 'lucide-vue-next';

defineProps({
    tags: Array,
    isNameDisplayed: {
        type: Boolean,
        default: true,
    },
});

function badgeIcon(name) {
    switch (name) {
        case 'Wegetariański':
            return Leaf;
        case 'Wysokobiałkowy':
            return Dumbbell;
        case 'Ostry':
            return Flame;
        case 'Słodki':
            return Candy;
        case 'Szybki':
            return Zap;
        case 'Czasochłonny':
            return Hourglass;
        default:
            return Tag;
    }
}

function badgeClass(name) {
    switch (name) {
        case 'Wegetariański':
            return 'bg-green-600';
        case 'Wysokobiałkowy':
            return 'bg-blue-500';
        case 'Ostry':
            return 'bg-red-500';
        case 'Słodki':
            return 'bg-pink-500';
        case 'Szybki':
            return 'bg-orange-500';
        case 'Czasochłonny':
            return 'bg-gray-500';
    }
}
</script>

<template>
    <div class="mt-2 flex flex-wrap gap-2">
        <span
            v-for="tag in tags"
            :key="tag.id"
            class="text-s inline-flex gap-1 rounded px-2 py-1 font-semibold text-white"
            :class="badgeClass(tag.name)"
        >
            <component :is="badgeIcon(tag.name)" class="h-6 w-6" />
            <span v-if="isNameDisplayed">
                {{ tag.name }}
            </span>
        </span>
    </div>
</template>
