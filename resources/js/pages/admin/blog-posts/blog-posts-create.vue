<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiCheckbox from '@/components/ui/forms/checkbox/ui-checkbox.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiRichTextEditor from '@/components/ui/forms/rich-text-editor/ui-rich-text-editor.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Eye, FileText, Save } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const form = useForm({
    title: '',
    slug: '',
    content: '',
    is_published: false,
});

const showPreview = ref(false);

const generateSlug = (title: string) => {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
};

const handleTitleChange = (value: string) => {
    form.title = value;
    if (!form.slug || form.slug === generateSlug(form.title)) {
        form.slug = generateSlug(value);
    }
};

const renderedContent = computed(() => {
    return form.content;
});

const handleSubmit = () => {
    form.post(route('admin.blog.store'), {
        onSuccess: () => {
            // Redirect will happen automatically
        },
    });
};

const handleCancel = () => {
    window.history.back();
};
</script>

<template>
    <Head title="Create Blog Post" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Create Blog Post" subtitle="Write and publish a new blog post" :icon="FileText" variant="primary">
                <template #actions>
                    <div class="flex space-x-2">
                        <ui-button label="Cancel" variant="outline" size="sm" :prefix-icon="ArrowLeft" @click="handleCancel" />
                        <ui-button
                            v-if="form.content"
                            :label="showPreview ? 'Edit' : 'Preview'"
                            variant="secondary"
                            size="sm"
                            :prefix-icon="Eye"
                            @click="showPreview = !showPreview"
                        />
                    </div>
                </template>
            </common-page-header>

            <div class="grid grid-cols-1 gap-6">
                <!-- Form -->
                <div v-if="!showPreview" class="rounded-lg border bg-white p-6 shadow-sm">
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <!-- Title -->
                        <div>
                            <ui-input
                                v-model="form.title"
                                label="Title"
                                placeholder="Enter blog post title"
                                :error="form.errors.title"
                                required
                                @input="handleTitleChange"
                            />
                        </div>

                        <!-- Slug -->
                        <div>
                            <ui-input
                                v-model="form.slug"
                                label="Slug"
                                placeholder="auto-generated-from-title"
                                :error="form.errors.slug"
                                help="URL-friendly version of the title. Leave blank to auto-generate."
                            />
                        </div>

                        <!-- Content -->
                        <div>
                            <ui-rich-text-editor
                                v-model="form.content"
                                label="Content"
                                placeholder="Write your blog post content here..."
                                :error="form.errors.content"
                                :height="500"
                                required
                                help="Use the rich text editor to format your content with headings, lists, links, and more."
                            />
                        </div>

                        <!-- Published Status -->
                        <div>
                            <ui-checkbox
                                v-model="form.is_published"
                                label="Publish immediately"
                                help="If unchecked, the post will be saved as a draft"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <ui-button
                                type="submit"
                                :label="form.is_published ? 'Publish Post' : 'Save Draft'"
                                variant="primary"
                                :prefix-icon="Save"
                                :loading="form.processing"
                                :disabled="!form.title || !form.content"
                            />
                        </div>
                    </form>
                </div>

                <!-- Preview -->
                <div v-else class="rounded-lg border bg-white p-6 shadow-sm">
                    <div class="space-y-6">
                        <!-- Meta Information -->
                        <div class="border-b pb-4">
                            <h1 class="text-3xl font-bold text-gray-900">{{ form.title || 'Untitled Post' }}</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                                    <span :class="form.is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                                        {{ form.is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </span>
                            </div>
                            <div class="mt-1 text-sm text-gray-500">
                                Slug: <code class="rounded bg-gray-100 px-1 text-xs">{{ form.slug || 'auto-generated' }}</code>
                            </div>
                        </div>

                        <!-- Content Preview -->
                        <div class="prose max-w-none">
                            <div v-if="form.content" v-html="renderedContent"></div>
                            <p v-else class="text-gray-500 italic">No content to preview</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </sidebar-layout>
</template>
