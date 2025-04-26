<template>
    <div :class="$attrs.class" class="cursor-pointer" @click="select">
        <slot />
        <div v-if="$attrs.modelValue && field == $attrs.modelValue.field" class="ml-1 inline-block align-middle">
            <icon v-if="$attrs.modelValue.direction === 'asc'" name="arrow-down" class="block h-4 w-4 fill-gray-400" />
            <icon v-else name="arrow-up" class="block h-4 w-4 fill-gray-400" />
        </div>
    </div>
</template>

<script>
import Icon from '@/Shared/Icon';

export default {
    components: {
        Icon,
    },
    inheritAttrs: false,
    props: {
        field: {
            type: String,
            default: null,
        },
    },
    emits: ['update:modelValue'],
    methods: {
        select() {
            this.$emit('update:modelValue', {
                field: this.field,
                direction: this.$attrs.modelValue && this.$attrs.modelValue.direction === 'asc' ? 'desc' : 'asc',
            });
        },
    },
};
</script>
