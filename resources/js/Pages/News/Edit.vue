<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import PageContainer from "@/Components/PageContainer.vue"
import PageContainerBlock from "@/Components/PageContainerBlock.vue"
import InputError from "@/Components/InputError.vue"
import InputLabel from "@/Components/InputLabel.vue"
import {useForm} from "@inertiajs/vue3"
import PageContainerBlockDivider from "@/Components/PageContainerBlockDivider.vue"
import {useToast} from "primevue"

const toast = useToast()

const props = defineProps({
    news: {
        type: Object,
        required: true
    }
})

const news = props.news

const form = useForm({
    title_ru: news.title_ru,
    title_en: news.title_en,
    announce_ru: news.announce_ru,
    announce_en: news.announce_en,
    text_ru: news.text_ru,
    text_en: news.text_en,
    show: Boolean(news.show)
})

function upload() {
    form.post(
        route('news.update', {id: news.id}),
        {
            onSuccess: () => {
                toast.add({severity: 'success', summary: 'Success', detail: 'News updated'})
            }
        }
    )
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            {{ news.title_ru }}
        </template>

        <PageContainer>
            <PageContainerBlock>
                <form @submit.prevent="upload()" class="space-y-6">
                    <div>
                        <InputLabel for="title_ru" value="Title Ru"/>

                        <InputText
                            id="title_ru"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title_ru"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.title_ru"/>
                    </div>
                    <div>
                        <InputLabel for="title_en" value="Title En"/>

                        <InputText
                            id="title_ru"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title_en"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.title_en"/>
                    </div>

                    <div>
                        <InputLabel for="announce_ru" value="Announce Ru"/>

                        <Editor class="mt-1 block w-full"
                                  id="body"
                                  v-model="form.announce_ru"
                                  required>
                        </Editor>

                        <InputError class="mt-2" :message="form.errors.announce_ru"/>
                    </div>
                    <div>
                        <InputLabel for="announce_en" value="Announce En"/>

                        <Editor class="mt-1 block w-full"
                                  id="body"
                                  v-model="form.announce_en"
                                  required>
                        </Editor>

                        <InputError class="mt-2" :message="form.errors.announce_en"/>
                    </div>

                    <div>
                        <InputLabel for="text_ru" value="Text Ru"/>

                        <Editor class="mt-1 block w-full"
                                  id="body"
                                  v-model="form.text_ru"
                                  required>
                        </Editor>

                        <InputError class="mt-2" :message="form.errors.text_ru"/>
                    </div>
                    <div>
                        <InputLabel for="text_en" value="Text En"/>

                        <Editor class="mt-1 block w-full"
                                  id="body"
                                  v-model="form.text_en"
                                  required>
                        </Editor>

                        <InputError class="mt-2" :message="form.errors.text_en"/>
                    </div>

                    <div>
                        <InputLabel for="show" value="Show"/>

                        <Checkbox class="mt-2" v-model="form.show" binary/>

                        <InputError class="mt-2" :message="form.errors.show"/>
                    </div>

                    <PageContainerBlockDivider/>

                    <div class="flex flex-row gap-x-2">
                        <Button type="submit">Update</Button>
                        <a :href="route('news.index')">
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
