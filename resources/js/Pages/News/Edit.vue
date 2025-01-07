<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import PageContainerBlockDivider from '@/Components/PageContainerBlockDivider.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';

const toast = useToast();

const props = defineProps({
    news: {
        type: Object,
        required: true
    },
    languages: {
        type: Array,
        required: true
    }
});

const news = props.news;

let fields = {
    show: Boolean(news.show)
};

props.news.news_data?.forEach((item) => {
    fields['news_data_' + item.language + '_id'] = item.id;
    fields['title_' + item.language] = item.title;
    fields['announce_' + item.language] = item.announce;
    fields['text_' + item.language] = item.text;
});

const form = useForm(fields);

function upload() {
    form.post(route('news.update', { id: news.id }), {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'News updated'
            });
        }
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
                <template v-for="(language, index) in languages" v-bind:key="index">
                    <input type="hidden" v-model="form['news_data_' + language + '_id']" />

                    <div>
                        <InputLabel :for="'title_' + language" :value="'Title ' + language.toLowerCase()" />

                        <InputText
                            :id="'title_' + language"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form['title_' + language]"
                            required
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors['title_' + language]"
                        />
                    </div>

                    <div>
                        <InputLabel :for="'announce_' + language" :value="'Announce ' + language.toLowerCase()" />

                        <Editor
                            :id="'announce_' + language"
                            class="mt-1 block w-full"
                            v-model="form['announce_' + language]"
                            required
                        >
                        </Editor>

                        <InputError
                            class="mt-2"
                            :message="form.errors['announce_' + language]"
                        />
                    </div>

                    <div>
                        <InputLabel :for="'text_' + language" :value="'Text ' + language.toLowerCase()" />

                        <Editor
                            :id="'text_' + language"
                            class="mt-1 block w-full"
                            v-model="form['text_' + language]"
                            required
                        >
                        </Editor>

                        <InputError
                            class="mt-2"
                            :message="form.errors['text_' + language]"
                        />
                    </div>

                    <hr class="border-black" v-if="index !== languages.length - 1">
                </template>

                <div>
                    <InputLabel for="show" value="Show" />

                    <Checkbox class="mt-2" v-model="form.show" binary />

                    <InputError class="mt-2" :message="form.errors.show" />
                </div>

                <PageContainerBlockDivider />

                <div class="flex flex-row gap-x-2">
                    <Button type="submit">Update</Button>
                    <a :href="route('news.index')">
                        <Button type="button" severity="contrast"
                        >Back
                        </Button
                        >
                    </a>
                </div>
            </form>
        </PageContainerBlock>
    </AuthenticatedLayout>
</template>
