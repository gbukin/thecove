<script setup lang="ts">
import getNews, { News } from '@/API/news';
import IconPencil from '@/Components/Icons/IconPencil.vue';
import IconRefresh from '@/Components/Icons/IconRefresh.vue';
import NavLink from '@/Components/NavLink.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import HeaderCell from '@/Components/Table/HeaderCell.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, watch } from 'vue';

const pending = ref(false);
const interactiveCells = ['ID', 'Title Ru', 'Title En'];
const rows = ref<News[]>([]);
const sortColumn = ref('ID');
const sortDirection = ref('ASC');
const searchId = ref('');
const searchTitleRu = ref('');
const searchTitleEn = ref('');
const searchShow = ref('All');
// @ts-ignore
const searchHandlerTimeout = ref(setTimeout(() => {}, 0));

const sync = () => {
    pending.value = true;

    let data = {
        sortColumn: sortColumn.value,
        sortDirection: sortDirection.value,
        search: {},
    };

    if (
        searchId.value.length ||
        searchTitleRu.value.length ||
        searchTitleEn.value.length ||
        searchShow.value !== 'All'
    ) {
        data.search = {
            id: searchId.value,
            title_ru: searchTitleRu.value,
            title_en: searchTitleEn.value,
            show: searchShow.value,
        };
    }

    getNews(data)
        .then((r) => (rows.value = r.data))
        .finally(() => (pending.value = false));
};

const changeSort = (newSortColumn: string) => {
    sortColumn.value = newSortColumn;
    sync();
};

const changeSortDirection = () => {
    sortDirection.value = sortDirection.value === 'ASC' ? 'DESC' : 'ASC';
    sync();
};

watch(searchId, handleSearch);
watch(searchTitleRu, handleSearch);
watch(searchTitleEn, handleSearch);
watch(searchShow, handleSearch);

function handleSearch() {
    if (searchHandlerTimeout.value) {
        clearTimeout(searchHandlerTimeout.value);
    }

    searchHandlerTimeout.value = setTimeout(sync, 200);
}

onMounted(() => sync());
</script>

<template>
    <AuthenticatedLayout>
        <template #header> News list </template>

        <PageContainerBlock>
            <div class="mb-4">
                <a :href="route('news.create')">
                    <Button severity="info">Create</Button>
                </a>
            </div>

            <table>
                <thead>
                    <tr class="searchable-fields">
                        <th class="w-4">
                            <InputText
                                v-model="searchId"
                                placeholder="Search by ID"
                            />
                        </th>
                        <th class="w-72">
                            <InputText
                                v-model="searchTitleRu"
                                placeholder="Search by Title Ru"
                            />
                        </th>
                        <th class="w-72">
                            <InputText
                                v-model="searchTitleEn"
                                placeholder="Search by Title En"
                            />
                        </th>
                        <th>
                            <Select
                                v-model="searchShow"
                                :options="['All', 'Yes', 'No']"
                            />
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <HeaderCell
                            v-for="(cell, index) in interactiveCells"
                            v-bind:key="index"
                            :name="cell"
                            :active-sort="sortColumn === cell"
                            :sort-direction="sortDirection"
                            v-on:sort="changeSort(cell)"
                            v-on:sort:direction="changeSortDirection"
                        />
                        <th>Show</th>
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
                        <td>{{ row.show ? 'Yes' : 'No' }}</td>
                        <td>{{ row.date }}</td>
                        <td>{{ row.updated_at }}</td>
                        <td>
                            <NavLink :href="route('news.edit', { id: row.id })">
                                <IconPencil />
                            </NavLink>
                        </td>
                    </tr>
                    <tr v-if="!rows.length">
                        <td colspan="6" class="h-16 text-center">
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

<style scoped>
th {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
</style>
