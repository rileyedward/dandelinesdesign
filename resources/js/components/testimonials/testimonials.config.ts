import { Testimonial } from '@/types/components/testimonial';

export const testimonials: Testimonial[] = [
    {
        text: "Michele's attention to detail and creative vision transformed our wedding into a magical experience. Every element was thoughtfully designed and executed perfectly.",
        author: 'Sarah & John, Wedding Clients',
    },
    {
        text: 'Working with Dandelines Design for our corporate event was a pleasure. Michele understood our brand and created an atmosphere that impressed all our guests and partners.',
        author: 'Mark Davis, CEO of TechCorp',
    },
    {
        text: 'The floral arrangements Michele created for our anniversary celebration were absolutely stunning. Her artistic eye and ability to bring our vision to life exceeded all expectations.',
        author: 'Emily Johnson',
    },
    {
        text: 'Michele has a unique talent for creating spaces that feel both elegant and welcoming. Her design work for our home renovation project was exceptional.',
        author: 'The Williams Family',
    },
    {
        text: "From concept to execution, Dandelines Design delivered a birthday celebration that my daughter will remember forever. Michele's creativity and professionalism are unmatched.",
        author: 'Rebecca Thompson',
    },
];

// Configuration for testimonial rotation (in milliseconds)
export const testimonialRotationInterval = 8000; // 8 seconds
