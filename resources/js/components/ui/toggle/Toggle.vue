<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Toggle } from 'reka-ui';
import { cn } from '@/lib/utils';

interface Props {
    modelValue?: boolean;
    defaultValue?: boolean;
    disabled?: boolean;
    name?: string;
    class?: HTMLAttributes['class'];
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: undefined,
    disabled: false,
});

const emits = defineEmits<{
    (e: 'update:modelValue', payload: boolean): void;
}>();
</script>

<template>
    <Toggle
        data-slot="toggle"
        :model-value="props.modelValue"
        :default-value="props.defaultValue"
        :disabled="props.disabled"
        :name="props.name"
        @update:model-value="(value) => emits('update:modelValue', !!value)"
        :class="
            cn(
                'group inline-flex h-5 w-9 shrink-0 cursor-pointer items-center rounded-full border border-transparent shadow-xs transition-colors outline-none',
                'data-[state=on]:bg-primary data-[state=off]:bg-input',
                'focus-visible:ring-ring/50 focus-visible:ring-[3px]',
                'disabled:cursor-not-allowed disabled:opacity-50',
                props.class
            )
        "
    >
        <span
            data-slot="toggle-thumb"
            :class="
                cn(
                    'pointer-events-none block size-4 rounded-full bg-background shadow-lg ring-0 transition-transform',
                    'translate-x-0.5 group-data-[state=on]:translate-x-[18px]'
                )
            "
        />
    </Toggle>
</template>
