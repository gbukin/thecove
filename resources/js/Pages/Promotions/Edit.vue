<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import PageContainer from "@/Components/PageContainer.vue"
import PageContainerBlock from "@/Components/PageContainerBlock.vue"
import InputError from "@/Components/InputError.vue"
import InputLabel from "@/Components/InputLabel.vue"
import {useForm} from "@inertiajs/vue3"
import {languages} from "@/constants"
import PageContainerBlockDivider from "@/Components/PageContainerBlockDivider.vue"
import {computed, ref} from "vue"
import {useToast} from "primevue"

const toast = useToast()

const props = defineProps({
    promotion: {
        type: Object,
        required: true,
    },
    currentPicturePath: {
        type: String,
        required: true,
    }
})

const currentPicture = ref(props.currentPicturePath)
const promotion = props.promotion

const form = useForm({
    title: promotion.title,
    description: promotion.description,
    body: promotion.body,
    picture: null,
    language: promotion.language,
    start_at: new Date(promotion.start_at),
})

const previewSrc = computed(() => {
    return form.picture ? URL.createObjectURL(form.picture) : ''
})

function upload() {
    form.post(
        route('promotions.update', {id: promotion.id}),
        {
            onSuccess: () => {
                if (form.picture) {
                    currentPicture.value = URL.createObjectURL(form.picture)
                    form.reset()
                }
                toast.add({severity: 'success', summary: 'Success', detail: 'Promotion updated'})
            }
        }
    )
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            {{ promotion.title }}
        </template>

        <PageContainer>
            <PageContainerBlock>
                <form @submit.prevent="upload()" class="space-y-6">
                    <div>
                        <InputLabel for="title" value="Title"/>

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
                        <InputLabel for="description" value="Description"/>

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
                        <InputLabel for="body" value="Body"/>

                        <Editor class="mt-1 block w-full"
                                  id="body"
                                  v-model="form.body"
                                  required>
                        </Editor>

                        <InputError class="mt-2" :message="form.errors.body"/>
                    </div>
                    <div>
                        <InputLabel for="picture" value="Picture"/>

                        <figure>
                            <img :src="currentPicture" class="mx-auto w-64 h-64">
                            <figcaption>Current</figcaption>
                        </figure>

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
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.language"
                            :options="languages"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.language"/>
                    </div>
                    <div>
                        <InputLabel for="start_at" value="Start At"/>

                        <DatePicker
                            id="start_at"
                            class="mt-1 block"
                            v-model="form.start_at"
                            date-format="dd/mm/yy"
                            :min-date="new Date"
                            :manual-input="false"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.start_at"/>
                    </div>

                    <PageContainerBlockDivider/>

                    <div class="flex flex-row gap-x-2">
                        <Button type="submit">Update</Button>
                        <a :href="route('promotions.index')">
                            <Button type="button" severity="contrast">Back</Button>
                        </a>
                    </div>
                </form>
            </PageContainerBlock>
        </PageContainer>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
