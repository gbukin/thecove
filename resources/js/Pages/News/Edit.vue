<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import PageContainerBlockDivider from '@/Components/PageContainerBlockDivider.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import { NewsData, NewsForm } from '@/API/news';
import { computed, ref } from 'vue';

const toast = useToast();

const props = defineProps({
    news: {
        type: Object,
        required: true,
    },
    currentPicturePath: {
        type: String,
        required: true
    },
    languages: {
        type: Array<string>,
        required: true,
    },
});

const currentPicture = ref(props.currentPicturePath);
const news = props.news;

let fields:NewsForm = {
    picture: null,
    show: Boolean(news.show),
};

props.news.news_data?.forEach((item: NewsData) => {
    const language: string = item.language;

    fields['news_data_' + language + '_id' as keyof NewsForm] = item.id.toString();
    fields['title_' + language as keyof NewsForm] = item.title;
    fields['announce_' + language as keyof NewsForm] = item.announce;
    fields['text_' + language as keyof NewsForm] = item.text;
});

const form = useForm(fields);

const previewSrc = computed(() => {
    return form.picture ? URL.createObjectURL(form.picture) : null;
});

function upload() {
    console.log(form)
    form.post(route('news.update', { id: news.id }), {
        onSuccess: () => {
            if (form.picture) {
                currentPicture.value = URL.createObjectURL(form.picture);
                form.reset();
            }
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'News updated',
            });
        },
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            {{ news.title_ru }}
        </template>

        <PageContainerBlock>
            <form @submit.prevent="upload()" class="space-y-6">
                <template
                    v-for="(language, index) in languages"
                    v-bind:key="index"
                >
                    <input
                        type="hidden"
                        v-model="form['news_data_' + language + '_id']"
                    />

                    <div>
                        <InputLabel
                            :for="'title_' + language"
                            :value="'Title ' + language.toLowerCase()"
                        />

                        <InputText
                            :id="'title_' + language"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form['title_' + language]"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors['title_' + language]"
                        />
                    </div>

                    <div>
                        <InputLabel
                            :for="'announce_' + language"
                            :value="'Announce ' + language.toLowerCase()"
                        />

                        <Editor
                            :id="'announce_' + language"
                            class="mt-1 block w-full"
                            v-model="form['announce_' + language]"
                        >
                        </Editor>

                        <InputError
                            class="mt-2"
                            :message="form.errors['announce_' + language]"
                        />
                    </div>

                    <div>
                        <InputLabel
                            :for="'text_' + language"
                            :value="'Text ' + language.toLowerCase()"
                        />

                        <Editor
                            :id="'text_' + language"
                            class="mt-1 block w-full"
                            v-model="form['text_' + language]"
                        >
                        </Editor>

                        <InputError
                            class="mt-2"
                            :message="form.errors['text_' + language]"
                        />
                    </div>

                    <hr
                        class="border-black"
                        v-if="index !== languages.length - 1"
                    />
                </template>

                <div>
                    <InputLabel for="picture" value="Picture" />

                    <figure v-if="currentPicture">
                        <img
                            :src="currentPicture"
                            class="mx-auto h-64 w-64"
                            alt="current"
                        />
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
                        <img
                            :src="previewSrc"
                            class="mx-auto h-64 w-64"
                            v-if="previewSrc"
                            alt="new"
                        />
                        <figcaption>Preview</figcaption>
                    </figure>

                    <InputError class="mt-2" :message="form.errors.picture" />
                </div>

                <div>
                    <InputLabel for="show" value="Show" />

                    <Checkbox class="mt-2" id="show" v-model="form.show" binary />

                    <InputError class="mt-2" :message="form.errors.show" />
                </div>

                <PageContainerBlockDivider />

                <div class="flex flex-row gap-x-2">
                    <Button type="submit">Update</Button>
                    <a :href="route('news.index')">
                        <Button type="button" severity="contrast">Back </Button>
                    </a>
                </div>
            </form>
        </PageContainerBlock>
    </AuthenticatedLayout>
</template>
