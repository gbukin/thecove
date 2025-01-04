<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import PageContainerBlock from "@/Components/PageContainerBlock.vue"
import {onMounted, ref} from "vue"
import IconRefresh from "@/Components/Icons/IconRefresh.vue"
import IconPencil from "@/Components/Icons/IconPencil.vue";
import NavLink from "@/Components/NavLink.vue";
import getPromotions, {Promotions} from "@/API/promotions";
import IconNoImage from '@/Components/Icons/IconNoImage.vue';

const rows = ref<Promotions[]>([])

const pending = ref(false)

onMounted(() => {
    pending.value = true;

    getPromotions()
        .then((r) => rows.value = r.data)
        .finally(() => pending.value = false)
})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            Promotions list
        </template>

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
                    <th>Title</th>
                    <th>Description</th>
                    <th>Language</th>
                    <th>Picture</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in rows">
                    <td>{{ row.id }}</td>
                    <td>{{ row.title }}</td>
                    <td>{{ row.description }}</td>
                    <td>{{ row.language }}</td>
                    <td class="flex items-center justify-center">
                        <img :src="row.picture" class="size-16" v-if="row.picture">
                        <IconNoImage class="size-16" v-else/>
                    </td>
                    <td>{{ row.created_at }}</td>
                    <td>{{ row.updated_at }}</td>
                    <td>
                        <NavLink :href="route('promotions.edit', {id: row.id})">
                            <IconPencil/>
                        </NavLink>
                    </td>
                </tr>
                <tr v-if="!rows.length">
                    <td colspan="9" class="text-center h-16">
                        <IconRefresh class="animate-spin mx-auto" v-if="pending"/>
                        <span v-else>N/A</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </PageContainerBlock>
    </AuthenticatedLayout>
</template>
