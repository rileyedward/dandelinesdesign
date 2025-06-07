<script setup lang="ts">
import { TestimonialUpdateModalProps as Props, TestimonialUpdateModalEmits as Emits } from '@/types/components/testimonial-update-modal';
import { TestimonialData } from '@/types/models/testimonial';
import { ref, watch } from 'vue';
import { Save, X } from 'lucide-vue-next';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const isVisible = ref(false);
const form = ref<TestimonialData>({
    name: '',
    message: '',
});

watch(() => props.isOpen, (newValue) => {
    if (newValue) {
        setTimeout(() => {
            isVisible.value = true;
        }, 50);

        if (props.testimonial) {
            form.value = {
                name: props.testimonial.name,
                message: props.testimonial.message,
            };
        }
    } else {
        isVisible.value = false;
    }
}, { immediate: true });

const closeModal = () => {
    isVisible.value = false;
    setTimeout(() => {
        emit('close');
    }, 300);
};

const handleSubmit = () => {
    if (props.testimonial) {
        emit('update', props.testimonial.id, form.value);
    } else {
        emit('create', form.value);
    }
    closeModal();
};
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div
                class="fixed inset-0 bg-gray-500 transition-opacity"
                :class="{ 'bg-opacity-75': isVisible, 'bg-opacity-0': !isVisible }"
                @click="closeModal"
                aria-hidden="true"
            ></div>

            <!-- Modal panel -->
            <div
                class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle"
                :class="{ 'opacity-100 translate-y-0': isVisible, 'opacity-0 translate-y-4': !isVisible }"
            >
                <form @submit.prevent="handleSubmit">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                    {{ props.testimonial ? 'Update Testimonial' : 'Add Testimonial' }}
                                </h3>

                                <div class="mt-6 space-y-6">
                                    <div>
                                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Name</label>
                                        <input
                                            type="text"
                                            id="name"
                                            v-model="form.name"
                                            class="block w-full rounded-md border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label for="message" class="mb-2 block text-sm font-medium text-gray-700">Message</label>
                                        <textarea
                                            id="message"
                                            v-model="form.message"
                                            rows="5"
                                            class="block w-full rounded-md border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                            required
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none sm:ml-3"
                            title="Save"
                        >
                            <Save class="h-5 w-5" />
                        </button>
                        <button
                            type="button"
                            class="inline-flex justify-center rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none sm:ml-3"
                            @click="closeModal"
                            title="Cancel"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
