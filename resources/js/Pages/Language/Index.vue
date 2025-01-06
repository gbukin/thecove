<script setup lang="ts">
import IconNoImage from '@/Components/Icons/IconNoImage.vue';
import IconPencil from '@/Components/Icons/IconPencil.vue';
import IconRefresh from '@/Components/Icons/IconRefresh.vue';
import NavLink from '@/Components/NavLink.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref } from 'vue';
import getLanguages, { Language } from '@/API/language';

const rows = ref<Language[]>([]);

const pending = ref(false);

onMounted(() => {
    pending.value = true;

    getLanguages()
        .then((r) => (rows.value = r.data))
        .finally(() => (pending.value = false));
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header> Languages list </template>

        <PageContainerBlock>
            <div class="mb-4">
                <a :href="route('language.create')">
                    <Button severity="info">Create</Button>
                </a>
            </div>

            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(row, index) in rows" v-bind:key="index">
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.created_at }}</td>
                </tr>
                <tr v-if="!rows.length">
                    <td colspan="9" class="h-16 text-center">
                        <IconRefresh
                            class="mx-auto animate-spin"
                            v-if="pending"
                        />
                        <span v-else>N/A</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </PageContainerBlock>
    </AuthenticatedLayout>
</template>
