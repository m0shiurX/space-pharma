<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const name = page.props.name;
const quote = page.props.quote;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="relative flex-col justify-center items-center grid lg:grid-cols-2 px-8 sm:px-0 lg:px-0 lg:max-w-none h-dvh">
        <div class="relative lg:flex flex-col hidden bg-muted p-10 dark:border-r h-full text-white">
            <div class="absolute inset-0 bg-zinc-900" />
            <Link :href="route('dashboard')" class="relative z-20 flex items-center font-medium text-lg">
            <AppLogoIcon class="mr-2 text-white size-8 fill-current" />
            {{ name }}
            </Link>
            <div v-if="quote" class="relative z-20 mt-auto">
                <blockquote class="space-y-2">
                    <p class="text-lg">&ldquo;{{ quote.message }}&rdquo;</p>
                    <footer class="text-neutral-300 text-sm">{{ quote.author }}</footer>
                </blockquote>
            </div>
        </div>
        <div class="lg:p-8">
            <div class="flex flex-col justify-center space-y-6 mx-auto w-full sm:w-[350px]">
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="font-medium text-xl tracking-tight" v-if="title">{{ title }}</h1>
                    <p class="text-muted-foreground text-sm" v-if="description">{{ description }}</p>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
