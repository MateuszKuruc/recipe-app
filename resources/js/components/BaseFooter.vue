<script setup lang="ts">
import type { NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import {
    Beef, Beer, Coffee, Donut, EggFried, Heart, House,
    LayoutGrid, Milk, Plus, Popcorn, Salad, Scroll, Search, Soup
} from 'lucide-vue-next';

const page = usePage();
const user = page.props.auth.user;

const isActive = (href: string) => {
    const url = page.url;
    return url === href || url.startsWith(href + '?');
};

const footerLinkClass = (href: string) =>
    isActive(href)
        ? 'text-white font-bold underline hover:text-white hover:underline'
        : 'text-gray-200 hover:text-white hover:underline';

const mainNavItems: NavItem[] = [
    { title: 'Strona główna', href: '/' },
    { title: 'Przepisy', href: '/przepisy' },
    { title: 'Kategorie', href: '/kategorie' },
];

const footerNavItems: NavItem[] = user
    ? [
        { title: 'Dodaj nowy przepis', href: '/przepisy/dodaj' },
        { title: 'Ulubione przepisy', href: '/przepisy/ulubione'  },
        { title: 'Znajdź przepis', href: '/przepisy' },
    ]
    : [
        { title: 'Logowanie', href: '/login' },
        { title: 'Rejestracja', href: '/rejestracja' },
    ];

const categories: NavItem[] = [
    { title: 'Śniadania', href: '/kategorie/sniadania' },
    { title: 'Przekąski', href: '/kategorie/przekaski' },
    { title: 'Desery', href: '/kategorie/desery' },
    { title: 'Zupy', href: '/kategorie/zupy' },
    { title: 'Dania główne', href: '/kategorie/dania-glowne' },
    { title: 'Sałatki', href: '/kategorie/salatki' },
    { title: 'Napoje', href: '/kategorie/napoje-bezalkoholowe' },
    { title: 'Drinki', href: '/kategorie/drinki' },
    { title: 'Sosy i dodatki', href: '/kategorie/sosy-i-dodatki' },
];
</script>

<template>
    <footer class="mt-12 bg-primary dark:bg-stone-900 text-sm text-white">
        <!-- Main grid content -->
        <div class="border-t border-border px-6 py-10">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 sm:grid-cols-2 md:grid-cols-4">
                <!-- Navigation -->
                <div>
                    <h4 class="mb-2 text-xl font-semibold tracking-wide">Nawigacja</h4>
                    <ul class="space-y-1 text-lg">
                        <li><Link href="/" :class="footerLinkClass('/')">Strona główna</Link></li>
                        <li><Link href="/przepisy" :class="footerLinkClass('/przepisy')">Przepisy</Link></li>
                        <li><Link href="/kategorie" :class="footerLinkClass('/kategorie')">Kategorie</Link></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="mb-2 text-xl font-semibold tracking-wide">Kategorie</h4>
                    <ul class="space-y-1 text-lg">
                        <li v-for="item in categories" :key="item.href">
                            <Link :href="item.href" :class="footerLinkClass(item.href)">{{ item.title }}</Link>
                        </li>
                    </ul>
                </div>

                <!-- User tools -->
                <div>
                    <h4 class="mb-2 text-xl font-semibold tracking-wide">Dla Ciebie</h4>
                    <ul class="space-y-1 text-lg">
                        <li v-for="item in footerNavItems" :key="item.href">
                            <Link :href="item.href" :class="footerLinkClass(item.href)">{{ item.title }}</Link>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-border px-6 py-4 text-center text-lg text-gray-300 font-bold">
            © 2025 Mateusz Kuruc
        </div>
    </footer>
</template>
