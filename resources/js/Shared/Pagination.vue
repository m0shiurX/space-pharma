<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap justify-center -mb-1">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null" :key="key"
                    class="mr-1 mb-1 px-4 py-3 border rounded-sm text-gray-400 text-sm leading-4" v-html="link.label" />
                <Link preserve-scroll v-else :key="`link-${key}`"
                    class="hover:bg-white mr-1 mb-1 px-4 py-3 border focus:border-indigo-500 rounded-sm text-sm focus:text-indigo-500 leading-4"
                    :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
    props: {
        links: Array,
    },
};
</script>
