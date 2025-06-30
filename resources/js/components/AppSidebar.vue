<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Plus } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Strona główna',
        href: '/',
        icon: LayoutGrid,
    },
    {
        title: 'Przepisy',
        href: '/przepisy',
        icon: LayoutGrid,
    },
    {
        title: 'Kategorie',
        href: '/kategorie',
        icon: LayoutGrid,
        children: [
            {
                title: 'Śniadania',
                href: '/kategorie/sniadania',
                icon: LayoutGrid,
            },
            {
                title: 'Przekąski',
                href: '/kategorie/przekaski',
                icon: LayoutGrid,
            },
            {
                title: 'Desery',
                href: '/kategorie/desery',
                icon: LayoutGrid,
            },
            {
                title: 'Zupy',
                href: '/kategorie/zupy',
                icon: LayoutGrid,
            },
            {
                title: 'Dania główne',
                href: '/kategorie/dania-glowne',
                icon: LayoutGrid,
            },
            {
                title: 'Sałatki',
                href: '/kategorie/salatki',
                icon: LayoutGrid,
            },
            {
                title: 'Napoje',
                href: '/kategorie/napoje-bezalkoholowe',
                icon: LayoutGrid,
            },
            {
                title: 'Drinki',
                href: '/kategorie/drinki',
                icon: LayoutGrid,
            },
        ]
    }
];

const footerNavItems: NavItem[] = [

    {
        title: 'Dodaj nowy przepis',
        href: '/przepisy/dodaj',
        icon: Plus,
    },

];
</script>

<template>
    <Sidebar collapsible="icon" variant="floating">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('home')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
