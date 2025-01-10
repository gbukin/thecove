<script setup lang="ts">
import getPromotions, { Promotion } from '@/API/promotion';
import IconNoImage from '@/Components/Icons/IconNoImage.vue';
import IconPencil from '@/Components/Icons/IconPencil.vue';
import IconRefresh from '@/Components/Icons/IconRefresh.vue';
import NavLink from '@/Components/NavLink.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import IconDelete from '@/Components/Icons/IconDelete.vue';
import { dateToString } from '@/date-helper';

const rows = ref<Promotion[]>([]);

const pending = ref(false);

function removeFromResultSet(id: number) {
    for (let i = 0; i < rows.value.length; i++) {
        if (rows.value[i].id === id) {
            rows.value.splice(i, 1)
            break
        }
    }
}

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
                        <th class="text-center">Picture</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th></th>
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
                        <td>{{ dateToString(new Date(row.created_at)) }}</td>
                        <td>{{ dateToString(new Date(row.updated_at)) }}</td>
                        <td>
                            <NavLink
                                :href="route('promotions.edit', { id: row.id })"
                            >
                                <IconPencil />
                            </NavLink>
                        </td>
                        <td>
                            <Link
                                :href="route('promotions.delete', {id: row.id})"
                                @click="removeFromResultSet(row.id)"
                                method="delete"
                                as="button"
                            >
                                <IconDelete/>
                            </Link>
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
