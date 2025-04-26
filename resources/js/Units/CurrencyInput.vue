<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        required: true,
        type: Number,
        default: 0,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    step: {
        type: Number,
        default: 1,
    },
});

const emit = defineEmits(['update:modelValue']);

const CurrencyInput = computed({
    get() {
        return +Number(props.modelValue);
    },
    set(currencyInput) {
        emit('update:modelValue', currencyInput);
    },
});
</script>
<template>
    <div class="relative">
        <input
            :disabled="props.disabled"
            :step="props.step"
            type="number"
            class="h-full w-full border-orange-200 bg-orange-50 px-1 text-right selection:bg-orange-300 selection:text-orange-900 focus:border focus:border-orange-400 focus:ring-orange-600"
            :class="{ 'bg-slate-200': props.disabled }"
            @focus="$event.target.select()"
            v-model.number="CurrencyInput"
        />
    </div>
</template>
