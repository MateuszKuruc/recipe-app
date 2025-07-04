<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { LogOut, Settings } from 'lucide-vue-next';
import { useToast } from 'vue-toastification';

const toast = useToast();

interface Props {
    user: User;
}

const handleLogout = () => {
    router.post(
        route('logout'),
        {},
        {
            onSuccess: () => {
                toast.success('Wylogowano pomyślnie');
            },
            onError: () => {
                toast.error('Wystąpił błąd podczas wylogowania');
            },
        },
    );
};

defineProps<Props>();
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserInfo :user="user" :show-email="true" />
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup v-if="user">
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('profile.edit')" prefetch as="button">
                <Settings class="mr-2 h-4 w-4" />
                Ustawienia
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />

    <DropdownMenuItem v-if="user">
        <button class="flex w-full items-center px-2 py-1.5" @click="handleLogout">
            <LogOut class="mr-2 h-4 w-4" />
            Wyloguj się
        </button>
    </DropdownMenuItem>

    <DropdownMenuItem v-else>
        <Link class="flex w-full items-center px-2 py-1.5" :href="route('login')">
            <LogOut class="mr-2 h-4 w-4" />
            Zaloguj się
        </Link>
    </DropdownMenuItem>
</template>
