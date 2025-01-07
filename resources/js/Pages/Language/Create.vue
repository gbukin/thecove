<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import PageContainerBlockDivider from '@/Components/PageContainerBlockDivider.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header> Create Language</template>

        <PageContainerBlock>
            <form
                @submit.prevent="form.post(route('language.store'))"
                class="space-y-6"
            >
                <div>
                    <InputLabel for="name" value="Name" required />

                    <InputText
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <PageContainerBlockDivider />

                <div class="flex flex-row gap-x-2">
                    <Button type="submit">Create</Button>
                    <a :href="route('promotions.index')">
                        <Button type="button" severity="contrast">Back </Button>
                    </a>
                </div>
            </form>
        </PageContainerBlock>
    </AuthenticatedLayout>
</template>
