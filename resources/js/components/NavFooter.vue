<script setup lang="ts">
import { SidebarGroup, SidebarGroupContent, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3'; // ✅ Add usePage

interface Props {
    items: NavItem[];
    class?: string;
}

defineProps<Props>();

const page = usePage(); // ✅ Access current page URL
</script>

<template>
    <SidebarGroup :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`">
        <SidebarGroupContent>
            <SidebarMenu class="flex flex-col gap-3 py-4 rounded-xl border border-gray-400 mb-6 items-start">
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton
                        :is-active="item.href === page.url || page.url.startsWith(item.href + '?')"
                    class="text-neutral-600 dark:text-neutral-300 dark:hover:text-neutral-100 hover:text-white hover:font-bold"
                    :tooltip="item.title"
                    as-child
                    >
                    <Link :href="item.href" class="pl-3">
                        <div class="h-6 w-6 shrink-0">
                            <component :is="item.icon" class="h-full w-full" />
                        </div>
                        <span class="text-xl">{{ item.title }}</span>
                    </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>
