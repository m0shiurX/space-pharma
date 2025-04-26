<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        required: false,
        type: String,
        default: '',
    },
    label: {
        required: true,
        type: String,
    },
    error: String,
});

const emit = defineEmits(['update:modelValue']);

const textInput = computed({
    get() {
        return props.modelValue;
    },
    set(textInputString) {
        emit('update:modelValue', textInputString);
    },
});
</script>
<template>
    <div class="mb-5">
        <label class="mb-2 block" :for="props.label"> {{ props.label }} </label>
        <input
            :id="props.label"
            class="h-10 w-full rounded-md border border-orange-400 bg-orange-50 focus:border focus:border-orange-400 focus:ring-orange-600"
            type="text"
            placeholder=""
            v-model="textInput"
        />
        <div v-if="error" class="text-xs text-red-400">{{ error }}</div>
    </div>
</template>
