<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import PageContainerBlockDivider from '@/Components/PageContainerBlockDivider.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { NewsForm } from '@/API/news';

const props = defineProps({
    languages: {
        type: Array<string>,
        required: true,
    },
});

let fields:NewsForm = {
    show: false,
};

props.languages?.forEach((language: string) => {
    fields[`title_${language}` as keyof NewsForm] = '';
    fields[`announce_${language}` as keyof NewsForm] = '';
    fields[`text_${language}` as keyof NewsForm] = '';
});

const form = useForm(fields);
</script>

<template>
    <AuthenticatedLayout>
        <template #header> Create News</template>

        <PageContainerBlock>
            <form
                @submit.prevent="form.post(route('news.store'))"
                class="space-y-6"
            >
                <template
                    v-for="(language, index) in languages"
                    v-bind:key="index"
                >
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
                            required
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
                            required
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
                            required
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
                    <InputLabel for="show" value="Show" />

                    <Checkbox class="mt-2" v-model="form.show" binary />

                    <InputError class="mt-2" :message="form.errors.show" />
                </div>

                <PageContainerBlockDivider />

                <div class="flex flex-row gap-x-2">
                    <Button type="submit">Create</Button>
                    <a :href="route('news.index')">
                        <Button type="button" severity="contrast">Back </Button>
                    </a>
                </div>
            </form>
        </PageContainerBlock>
    </AuthenticatedLayout>
</template>
