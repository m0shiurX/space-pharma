<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex flex-col justify-center items-center gap-6 bg-background p-6 md:p-10 min-h-svh">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="route('dashboard')" class="flex flex-col items-center gap-2 font-medium">
                        <div class="flex justify-center items-center mb-1 rounded-md w-9 h-9">
                            <AppLogoIcon class="text-[var(--foreground)] dark:text-white size-9 fill-current" />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="font-medium text-xl">{{ title }}</h1>
                        <p class="text-center text-muted-foreground text-sm">{{ description }}</p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
