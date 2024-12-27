<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import PageContainerBlock from "@/Components/PageContainerBlock.vue"
import {onMounted, ref, watch} from "vue"
import getNews, {News} from "@/API/news"
import IconRefresh from "@/Components/Icons/IconRefresh.vue"
import IconPencil from "@/Components/Icons/IconPencil.vue"
import NavLink from "@/Components/NavLink.vue"
import HeaderCell from "@/Components/Table/HeaderCell.vue";

const pending = ref(false)
const interactiveCells = ['ID', 'Title Ru', 'Title En']
const rows = ref<News[]>([])
const sortColumn = ref('ID')
const sortDirection = ref('ASC')
const searchId = ref('')
const searchTitleRu = ref('')
const searchTitleEn = ref('')
// @ts-ignore
const searchHandlerTimeout = ref(setTimeout(() => {}, 0))

const sync = () => {
    pending.value = true

    let data = {
        sortColumn: sortColumn.value,
        sortDirection: sortDirection.value,
        search: {}
    }

    if (searchId.value.length || searchTitleRu.value.length || searchTitleEn.value.length) {
        data.search = {
            id: searchId.value,
            title_ru: searchTitleRu.value,
            title_en: searchTitleEn.value,
        }
    }

    getNews(data)
        .then((r) => rows.value = r.data)
        .finally(() => pending.value = false)
}

const changeSort = (newSortColumn: string) => {
    sortColumn.value = newSortColumn
    sync()
}

const changeSortDirection = () => {
    sortDirection.value = sortDirection.value === 'ASC' ? 'DESC' : 'ASC'
    sync()
}

watch(searchId, handleSearch)
watch(searchTitleRu, handleSearch)
watch(searchTitleEn, handleSearch)

function handleSearch() {
    if (searchHandlerTimeout.value) {
        clearTimeout(searchHandlerTimeout.value)
    }

    searchHandlerTimeout.value = setTimeout(sync, 200)
}

onMounted(() => sync())
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            News list
        </template>

        <PageContainerBlock>
            <div class="mb-4">
                <a :href="route('news.create')">
                    <Button severity="info">Create</Button>
                </a>
            </div>

            <table>
                <thead>
                <tr class="searchable-fields">
                    <th class="w-4"><InputText v-model="searchId" placeholder="Search by ID"/></th>
                    <th class="w-72"><InputText v-model="searchTitleRu" placeholder="Search by Title Ru"/></th>
                    <th class="w-72"><InputText v-model="searchTitleEn" placeholder="Search by Title En"/></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <HeaderCell v-for="cell in interactiveCells"
                                :name="cell"
                                :active-sort="sortColumn === cell"
                                :sort-direction="sortDirection"
                                v-on:sort="changeSort(cell)"
                                v-on:sort:direction="changeSortDirection"
                    />
                    <th>Created</th>
                    <th>Updated</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in rows">
                    <td>{{ row.id }}</td>
                    <td>{{ row.title_ru }}</td>
                    <td>{{ row.title_en }}</td>
                    <td>{{ row.created_at }}</td>
                    <td>{{ row.updated_at }}</td>
                    <td>
                        <NavLink :href="route('news.edit', {id: row.id})">
                            <IconPencil/>
                        </NavLink>
                    </td>
                </tr>
                <tr v-if="!rows.length">
                    <td colspan="6" class="text-center h-16">
                        <IconRefresh class="animate-spin mx-auto" v-if="pending"/>
                        <span v-else>N/A</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </PageContainerBlock>
    </AuthenticatedLayout>
</template>

<style scoped>
th {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
</style>
