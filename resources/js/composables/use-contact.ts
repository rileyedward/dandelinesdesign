import { ContactData, UseContactReturn } from '@/types/composables/contact';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { route } from 'ziggy-js';

export function useContact(): UseContactReturn {
    const form = reactive<ContactData>({
        name: '',
        business_name: null,
        email: '',
        phone: null,
        subject: '',
        message: '',
    });

    const errors = reactive<Record<string, string>>({});

    const resetForm = () => {
        form.name = '';
        form.business_name = null;
        form.email = '';
        form.phone = null;
        form.subject = '';
        form.message = '';

        Object.keys(errors).forEach((key) => {
            delete errors[key];
        });
    };

    const submitForm = () => {
        router.post(route('contact.store'), form, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                resetForm();
            },
            onError: (err) => {
                Object.keys(err).forEach((key) => {
                    errors[key] = err[key];
                });
            },
        });
    };

    return {
        form,
        errors,
        resetForm,
        submitForm,
    };
}
