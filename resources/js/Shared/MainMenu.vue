<template>
    <div class="space-y-4">
        <MainMenuItem href="/dashboard" icon="dashboard" :active="isUrl('dashboard')">Dashboard</MainMenuItem>
        <MainMenuItem href="/sales" icon="cart" :active="isUrl('sales')">SALES</MainMenuItem>
        <MainMenuItem href="/purchases" icon="bag" :active="isUrl('purchases')">Purchase</MainMenuItem>
        <MainMenuItem href="/manufacturers" icon="manufacturer" :active="isUrl('manufacturers')">Manufacturers </MainMenuItem>
        <MainMenuItem href="/medicines" icon="clip-list" :active="isUrl('medicines')">Medicines</MainMenuItem>
        <MainMenuItem href="/customers" icon="user-group" :active="isUrl('customers')">Customers</MainMenuItem>
        <MainMenuItem href="/stocks" icon="stock" :active="isUrl('stocks')">Stocks</MainMenuItem>
        <MainMenuItem href="/profile" icon="user" :active="isUrl('profile')">Profile</MainMenuItem>
        <MainMenuItem href="/about" icon="list" :active="isUrl('about')">About</MainMenuItem>
    </div>
</template>

<script setup>
// Helpers
import { usePage } from '@inertiajs/vue3';
const { url } = usePage();
// Components
import MainMenuItem from './MainMenuItem.vue';
const isUrl = (...urls) => {
    const currentUrl = url.substring(1);
    if (urls[0] === '') {
        return currentUrl === '';
    }
    return urls.filter((url) => currentUrl.startsWith(url)).length;
};
</script>
