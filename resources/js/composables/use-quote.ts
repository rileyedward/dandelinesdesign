import { QuoteData, UseQuoteReturn } from '@/types/composables/quote';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { route } from 'ziggy-js';

export function useQuote(): UseQuoteReturn {
    const form = reactive<QuoteData>({
        name: '',
        business_name: null,
        email: '',
        phone: null,
        event_date: '',
        event_type: '',
        event_description: '',
        guest_count: 0,
        venue_name: null,
        venue_address: '',
        budget_range: '',
        special_requests: null,
    });

    const errors = reactive<Record<string, string>>({});

    const resetForm = () => {
        form.name = '';
        form.business_name = null;
        form.email = '';
        form.phone = null;
        form.event_date = '';
        form.event_type = '';
        form.event_description = '';
        form.guest_count = 0;
        form.venue_name = null;
        form.venue_address = '';
        form.budget_range = '';
        form.special_requests = null;

        Object.keys(errors).forEach((key) => {
            delete errors[key];
        });
    };

    const submitForm = () => {
        router.post(route('quote.store'), form, {
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
