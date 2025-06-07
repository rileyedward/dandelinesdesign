export function formatDate(dateString: string, dateOnly: boolean = false): string {
    const date = new Date(dateString);

    const options: Intl.DateTimeFormatOptions = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };

    if (!dateOnly) {
        options.hour = '2-digit';
        options.minute = '2-digit';
    }

    return date.toLocaleDateString('en-US', options);
}
