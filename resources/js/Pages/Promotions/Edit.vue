<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PageContainerBlock from '@/Components/PageContainerBlock.vue';
import PageContainerBlockDivider from '@/Components/PageContainerBlockDivider.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import { computed, ref } from 'vue';
import { PromotionData, PromotionForm } from '@/API/promotion';

const toast = useToast();

const props = defineProps({
    promotion: {
        type: Object,
        required: true,
    },
    currentPicturePath: {
        type: String,
        required: true,
    },
    languages: {
        type: Array<string>,
        required: true,
    },
});

const currentPicture = ref(props.currentPicturePath);
const promotion = props.promotion;

let fields:PromotionForm = {
    picture: null,
    start_at: new Date(promotion.start_at),
};

props.promotion.promotion_data?.forEach((item: PromotionData) => {
    const language: string = item.language;

    fields[`promotion_data_${language}_id` as keyof PromotionForm] = item.id.toString();
    fields[`title_${language}` as keyof PromotionForm] = item.title;
    fields[`description_${language}` as keyof PromotionForm] = item.description;
    fields[`body_${language}` as keyof PromotionForm] = item.body;
});

const form = useForm(fields);

const previewSrc = computed(() => {
    return form.picture ? URL.createObjectURL(form.picture) : null;
});

function upload() {
    form.post(route('promotions.update', { id: promotion.id }), {
        onSuccess: () => {
            if (form.picture) {
                currentPicture.value = URL.createObjectURL(form.picture);
                form.reset();
            }
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Promotion updated',
            });
        },
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            {{ promotion.title }}
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
                            :value="'Announce ' + language.toLowerCase()"
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
                            :value="'Text ' + language.toLowerCase()"
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

                    <figure>
                        <img :src="currentPicture" class="mx-auto h-64 w-64" />
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
                    <Button type="submit">Update</Button>
                    <a :href="route('promotions.index')">
                        <Button type="button" severity="contrast">Back </Button>
                    </a>
                </div>
            </form>
        </PageContainerBlock>
    </AuthenticatedLayout>
</template>
