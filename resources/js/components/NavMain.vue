<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
    items: NavItem[];
}>();

const page = usePage();
</script>

<template>
    <SidebarGroup class=" 'px-2 pt-6">
        <SidebarGroupLabel class="text-sm">Spis treści</SidebarGroupLabel>

        <SidebarMenu class="flex flex-col gap-4 pt-2">
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <!-- Regular nav item (no children) -->
                <SidebarMenuButton v-if="!item.children" as-child :is-active="item.href === '/'
    ? page.url === '/'
    : page.url === item.href || page.url.startsWith(item.href + '?')" :tooltip="item.title" size="lg">
                    <Link :href="item.href">
                        <div class="h-8 w-8 shrink-0">
                            <component :is="item.icon" class="h-full w-full" />
                        </div>
                        <span class="text-xl">{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>

                <!-- Parent item with nested children, still clickable -->
                <div v-else class="flex flex-col gap-1">
                    <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title" size="lg">
                        <Link :href="item.href">
                            <div class="h-8 w-8 shrink-0">
                                <component :is="item.icon" class="h-full w-full" />
                            </div>
                            <span class="text-xl">{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>

                    <SidebarMenu class="flex flex-col gap-3 pt-3 pl-6">
                        <SidebarMenuItem v-for="child in item.children" :key="child.title">
                            <SidebarMenuButton as-child :is-active="child.href === page.url" :tooltip="child.title" size="lg">
                                <Link :href="child.href">
                                    <div class="h-6 w-6 shrink-0">
                                        <component :is="child.icon" class="h-full w-full" />
                                    </div>
                                    <span class="text-lg">{{ child.title }}</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </div>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
