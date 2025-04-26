<template>
    <div class="flex items-center">
        <div class="flex w-full rounded-sm bg-white shadow-sm">
            <input
                class="focus:shadow-outline relative w-full rounded-md px-3 py-1.5 focus-within:ring-orange-400"
                autocomplete="off"
                type="text"
                name="search"
                placeholder="Type to filter..."
                v-model="search"
            />
        </div>
        <button
            class="ml-3 rounded-md bg-orange-500 py-2 px-4 text-sm text-gray-100 hover:text-gray-200 focus:text-orange-300"
            type="button"
            @click="$emit('reset')"
        >
            Reset
        </button>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        required: true,
        type: String,
        default: '',
    },
});
const emit = defineEmits(['update:modelValue', 'reset']);

const search = computed({
    get() {
        return props.modelValue;
    },
    set(searchString) {
        emit('update:modelValue', searchString);
    },
});
</script>
