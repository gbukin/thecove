<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import PageContainerBlockDivider from '@/Components/PageContainerBlockDivider.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { PromotionForm } from '@/API/promotion';

const props = defineProps({
    languages: {
        type: Array<string>,
        required: true,
    },
});

let fields:PromotionForm = {
    picture: null,
    start_at: new Date(),
};

props.languages?.forEach((language: string) => {
    fields[`title_${language}` as keyof PromotionForm] = '';
    fields[`description_${language}` as keyof PromotionForm] = '';
    fields[`body_${language}` as keyof PromotionForm] = '';
});

const form = useForm(fields);

const previewSrc = computed(() => {
    return form.picture ? URL.createObjectURL(form.picture) : '';
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header> Create Promotion</template>

        <PageContainerBlock>
            <form
                @submit.prevent="form.post(route('promotions.store'))"
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
                            :for="'description_' + language"
                            :value="'Description ' + language.toLowerCase()"
                        />

                        <Editor
                            :id="'description_' + language"
                            class="mt-1 block w-full"
                            v-model="form['description_' + language]"
                            required
                        >
                        </Editor>

                        <InputError
                            class="mt-2"
                            :message="form.errors['description_' + language]"
                        />
                    </div>

                    <div>
                        <InputLabel
                            :for="'body_' + language"
                            :value="'Body ' + language.toLowerCase()"
                        />

                        <Editor
                            :id="'body_' + language"
                            class="mt-1 block w-full"
                            v-model="form['body_' + language]"
                            required
                        >
                        </Editor>

                        <InputError
                            class="mt-2"
                            :message="form.errors['body_' + language]"
                        />
                    </div>

                    <hr
                        class="border-black"
                        v-if="index !== languages.length - 1"
                    />
                </template>

                <div>
                    <InputLabel for="picture" value="Picture" />

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
                            alt="uploaded media"
                            v-if="previewSrc"
                        />
                        <figcaption>Preview</figcaption>
                    </figure>

                    <InputError class="mt-2" :message="form.errors.picture" />
                </div>
                <div>
                    <InputLabel for="start_at" value="Start At" />

                    <DatePicker
                        id="start_at"
                        class="mt-1 block"
                        v-model="form.start_at"
                        date-format="dd/mm/yy"
                        :min-date="new Date()"
                        :manual-input="false"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.start_at" />
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
