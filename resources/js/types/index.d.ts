import type { PageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';

export interface SharedData extends PageProps {
    ziggy: Config & { location: string };
}
