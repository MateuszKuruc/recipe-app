<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Beef, Beer, Coffee, Donut, EggFried, Heart, House, LayoutGrid, Milk, Plus, Popcorn, Salad, Scroll, Search, Soup } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page = usePage();
const user = page.props.auth.user;

const mainNavItems: NavItem[] = [
    {
        title: 'Strona główna',
        href: '/',
        icon: House,
    },
    {
        title: 'Przepisy',
        href: '/przepisy',
        icon: Scroll,
    },
    {
        title: 'Kategorie',
        href: '/kategorie',
        icon: LayoutGrid,
        children: [
            {
                title: 'Śniadania',
                href: '/kategorie/sniadania',
                icon: EggFried,
            },
            {
                title: 'Przekąski',
                href: '/kategorie/przekaski',
                icon: Popcorn,
            },
            {
                title: 'Desery',
                href: '/kategorie/desery',
                icon: Donut,
            },
            {
                title: 'Zupy',
                href: '/kategorie/zupy',
                icon: Soup,
            },
            {
                title: 'Dania główne',
                href: '/kategorie/dania-glowne',
                icon: Beef,
            },
            {
                title: 'Sałatki',
                href: '/kategorie/salatki',
                icon: Salad,
            },
            {
                title: 'Napoje',
                href: '/kategorie/napoje-bezalkoholowe',
                icon: Coffee,
            },
            {
                title: 'Drinki',
                href: '/kategorie/drinki',
                icon: Beer,
            },
            {
                title: 'Sosy i dodatki',
                href: '/kategorie/sosy-i-dodatki',
                icon: Milk,
            },
        ],
    },
];

const footerNavItems: NavItem[] = user
    ? [
          {
              title: 'Dodaj nowy przepis',
              href: '/przepisy/dodaj',
              icon: Plus,
          },
          {
              title: 'Ulubione przepisy',
              href: '/przepisy/ulubione',
              icon: Heart,
          },
          {
              title: 'Znajdź przepis',
              href: '/przepisy/',
              icon: Search,
          },
      ]
    : [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
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
            <NavFooter v-if="user" :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
