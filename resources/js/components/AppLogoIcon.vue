<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Drumstick } from 'lucide-vue-next';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
   <Drumstick />
</template>
