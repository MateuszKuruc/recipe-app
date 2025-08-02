<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Pizza } from 'lucide-vue-next';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
   <Pizza />
</template>
