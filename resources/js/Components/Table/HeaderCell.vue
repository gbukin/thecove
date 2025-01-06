<script setup>
import IconArrowUpDown from '@/Components/Icons/IconArrowUpDown.vue';
import { computed, defineAsyncComponent } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    activeSort: {
        type: Boolean,
        default: false,
    },
    sortDirection: {
        type: String,
        default: 'ASC',
    },
});

const emit = defineEmits(['sort', 'sort:direction']);

const sortIcon = computed(() => {
    if (props.sortDirection === 'ASC') {
        return defineAsyncComponent(
            () => import('@/Components/Icons/IconArrowUp.vue'),
        );
    }

    return defineAsyncComponent(
        () => import('@/Components/Icons/IconArrowDown.vue'),
    );
});
</script>

<template>
    <th>
        <div class="flex flex-row items-center">
            <span>{{ name }}</span>

            <IconArrowUpDown
                v-if="!activeSort"
                class="cursor-pointer"
                @click="emit('sort')"
            />

            <div class="flex w-4 flex-row" v-else>
                <component
                    :is="sortIcon"
                    class="cursor-pointer text-green-600"
                    @click="emit('sort:direction')"
                />
            </div>
        </div>
    </th>
</template>
