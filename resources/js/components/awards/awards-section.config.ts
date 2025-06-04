import { Award } from '@/types/components/awards-section';

export const awards: Award[] = [
    {
        title: 'Excellence in Floral Design',
        organization: 'National Floral Association',
        year: '2023',
        description: 'Recognized for innovative floral arrangements and exceptional creativity in wedding designs.',
    },
    {
        title: 'Best Event Designer',
        organization: 'Regional Event Planning Guild',
        year: '2022',
        description: 'Awarded for outstanding contribution to event aesthetics and creative vision in corporate events.',
    },
    {
        title: 'Creative Entrepreneur of the Year',
        organization: 'Local Business Chamber',
        year: '2021',
        description: 'Honored for business innovation and artistic excellence in the field of event design.',
    },
    {
        title: 'Sustainable Design Award',
        organization: 'Green Events Coalition',
        year: '2020',
        description: 'Recognized for commitment to eco-friendly practices and sustainable design solutions.',
    },
];

export const awardsDisplayConfig = {
    showImages: true,
    maxDisplay: 4,
};
