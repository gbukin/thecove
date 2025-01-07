<script setup lang="ts">
import getPromotions, { Promotion } from '@/API/promotion';
import IconNoImage from '@/Components/Icons/IconNoImage.vue';
import IconPencil from '@/Components/Icons/IconPencil.vue';
import IconRefresh from '@/Components/Icons/IconRefresh.vue';
import NavLink from '@/Components/NavLink.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref } from 'vue';

const rows = ref<Promotion[]>([]);

const pending = ref(false);

onMounted(() => {
    pending.value = true;

    getPromotions()
        .then((r) => (rows.value = r.data))
        .finally(() => (pending.value = false));
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header> Promotions list </template>

        <PageContainerBlock>
            <div class="mb-4">
                <a :href="route('promotions.create')">
                    <Button severity="info">Create</Button>
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title Ru</th>
                        <th>Title En</th>
                        <th>Picture</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in rows" v-bind:key="index">
                        <td>{{ row.id }}</td>
                        <td>{{ row.title_ru }}</td>
                        <td>{{ row.title_en }}</td>
                        <td class="flex items-center justify-center">
                            <img
                                :src="row.picture"
                                class="size-16"
                                v-if="row.picture"
                                alt="media"
                            />
                            <IconNoImage class="size-16" v-else />
                        </td>
                        <td>{{ row.created_at }}</td>
                        <td>{{ row.updated_at }}</td>
                        <td>
                            <NavLink
                                :href="route('promotions.edit', { id: row.id })"
                            >
                                <IconPencil />
                            </NavLink>
                        </td>
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
