export interface ServiceBanner {
    image_url: string;
    title: string;
    description: string;
    imageOnLeft: boolean;
}

export interface ServiceBannerProps {
    service: ServiceBanner;
}
