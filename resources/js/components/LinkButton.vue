<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
  href: string;
  variant?: 'default' | 'outline' | 'destructive';
}>();

const base = 'inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors px-4 py-2 shadow-sm';

const variants: Record<string, string> = {
  default: 'bg-rose-700 text-white foreground hover:bg-rose-600 dark:hover:bg-rose-500',
  outline: 'border border-accent bg-background text-foreground hover:bg-accent dark:hover:bg-gray-300 hover:text-accent-foreground',
  destructive: 'bg-destructive text-destructive-foreground hover:bg-destructive/90',
};

const classes = `${base} ${variants[props.variant || 'default']}`;
</script>

<template>
  <Link :href="href" :class="classes">
    <slot />
  </Link>
</template>
