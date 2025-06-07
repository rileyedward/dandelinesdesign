import { ServiceBanner } from '@/types/components/service-banner';

export const services: ServiceBanner[] = [
    {
        image_url: '/images/services/event-service.jpg',
        title: 'Events',
        description:
            'Weddings, birthdays, corporate events, fundraisers, any special occasion, we are ready to participate. The details that make your event stand out are what we specialize in. We will be with you from beginning to end to insure your day goes flawlessly. Contact me for a custom proposal.',
        imageOnLeft: true,
    },
    {
        image_url: '/images/services/floral-service.jpg',
        title: 'Floral',
        description:
            'Beautiful flowers make a statement. They complete a table, brighten a room, say I love you , thank you, or just because. A single stem or a dozen of your favorite blooms, we can create any type of arrangement you need. Formal, contemporary, outside of the box ideas that make your event shine. I especially love creating that perfect table scape, as well as that little bouquet that says, thinking of you.',
        imageOnLeft: false,
    },
    {
        image_url: '/images/services/design-service.jpg',
        title: 'Artwork & Design',
        description:
            'Comprehensive digital marketing strategies to increase your online presence, drive traffic to your website, and convert visitors into customers.',
        imageOnLeft: true,
    },
];
