<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import PageContainerBlock from "@/Components/PageContainerBlock.vue"
import {onMounted, ref} from "vue"
import IconRefresh from "@/Components/Icons/IconRefresh.vue"
import getParticipators, { Participator } from '@/API/promotion_participators';

const rows = ref<Participator[]>([])

const pending = ref(false)

onMounted(() => {
    pending.value = true;

    getParticipators()
        .then((r) => rows.value = r.data)
        .finally(() => pending.value = false)
})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            Promotion Participators list
        </template>

        <PageContainerBlock>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Check Number</th>
                    <th>Check Sum</th>
                    <th>Check Time</th>
                    <th>Created</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in rows">
                    <td>{{ row.id }}</td>
                    <td>{{ row.full_name }}</td>
                    <td>{{ row.phone }}</td>
                    <td>{{ row.check_number }}</td>
                    <td>{{ row.check_sum }}</td>
                    <td>{{ row.check_time }}</td>
                    <td>{{ row.created_at }}</td>
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
