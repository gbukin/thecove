<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import PageContainer from "@/Components/PageContainer.vue"
import PageContainerBlock from "@/Components/PageContainerBlock.vue"
import InputError from "@/Components/InputError.vue"
import InputLabel from "@/Components/InputLabel.vue"
import {useForm} from "@inertiajs/vue3"
import {languages} from "@/constants"
import PageContainerBlockDivider from "@/Components/PageContainerBlockDivider.vue"
import {computed} from "vue";

const form = useForm({
    title: '',
    description: '',
    body: '',
    picture: null,
    language: '',
})

const previewSrc = computed(() => {
    return form.picture ? URL.createObjectURL(form.picture) : ''
})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            Create Promotion
        </template>

        <PageContainer>
            <PageContainerBlock>
                <form @submit.prevent="form.post(route('promotions.store'))" class="space-y-6">
                    <div>
                        <InputLabel for="title" value="Title" required/>

                        <InputText
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.title"/>
                    </div>
                    <div>
                        <InputLabel for="description" value="Description" required/>

                        <InputText
                            id="description"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.description"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.description"/>
                    </div>
                    <div>
                        <InputLabel for="body" value="Body" required/>

                        <Editor class="mt-1 block w-full"
                                id="body"
                                v-model="form.body"
                                required>
                        </Editor>

                        <InputError class="mt-2" :message="form.errors.body"/>
                    </div>
                    <div>
                        <InputLabel for="picture" value="Picture"/>

                        <FileUpload
                            id="language"
                            mode="basic"
                            severity="secondary"
                            class="p-button-outlined"
                            accept="image/*"
                            @select="form.picture = $event.files[0]"
                        />

                        <figure>
                            <img :src="previewSrc" class="mx-auto w-64 h-64" v-if="previewSrc"/>
                            <figcaption>Preview</figcaption>
                        </figure>

                        <InputError class="mt-2" :message="form.errors.picture"/>
                    </div>
                    <div>
                        <InputLabel for="language" value="Language"/>

                        <Select
                            id="language"
                            class="mt-1 block w-full"
                            v-model="form.language"
                            :options="languages"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.language"/>
                    </div>

                    <PageContainerBlockDivider/>

                    <div class="flex flex-row gap-x-2">
                        <Button type="submit">Create</Button>
                        <a :href="route('promotions.index')">
                            <Button type="button" severity="contrast">Back</Button>
                        </a>
                    </div>
                </form>
            </PageContainerBlock>
        </PageContainer>
    </AuthenticatedLayout>
</template>
