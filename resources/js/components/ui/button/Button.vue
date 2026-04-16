<script setup lang="ts">
import type { PrimitiveProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';
import type { ButtonVariants } from '.';
import { Primitive } from 'reka-ui';
import { cn } from '@/lib/utils';
import { buttonVariants } from '.';
import { Loader2 } from 'lucide-vue-next';

interface Props extends PrimitiveProps {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
    class?: HTMLAttributes['class'];
    loading?: boolean;
    disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    as: 'button',
    loading: false,
    disabled: false,
});
</script>

<template>
    <Primitive
        data-slot="button"
        :data-variant="variant"
        :data-size="size"
        :as="as"
        :as-child="asChild"
        :disabled="loading || disabled"
        :class="cn(
            buttonVariants({ variant, size }),
            (loading || disabled) && 'opacity-50 cursor-not-allowed',
            props.class
        )"
    >
        <Loader2 v-if="loading" class="mr-2 h-4 w-4 animate-spin" />

        <slot />
    </Primitive>
</template>
