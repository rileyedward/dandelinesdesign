<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiCheckbox from '@/components/ui/forms/checkbox/ui-checkbox.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiRichTextEditor from '@/components/ui/forms/rich-text-editor/ui-rich-text-editor.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ArrowLeft, FileText, Save } from 'lucide-vue-next';

const form = useForm({
    title: '',
    slug: '',
    content: '',
    is_published: false,
});

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
                    <ui-button label="Cancel" variant="outline" size="sm" :prefix-icon="ArrowLeft" @click="handleCancel" />
                </template>
            </common-page-header>

            <!-- Form -->
            <div class="rounded-lg border bg-white p-6 shadow-sm">
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <!-- Title -->
                    <div>
                        <ui-input
                            v-model="form.title"
                            label="Title"
                            placeholder="Enter blog post title"
                            :error="form.errors.title"
                            required
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
                        <ui-checkbox v-model="form.is_published" label="Publish immediately" help="If unchecked, the post will be saved as a draft" />
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
        </div>
    </sidebar-layout>
</template>
