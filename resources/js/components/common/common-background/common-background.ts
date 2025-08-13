export interface BackgroundProps {
    imageUrl?: string;
    height?: string;
    overlayColor?: string;
    overlayOpacity?: number;
    enableParallax?: boolean;
    gradientOverlay?: boolean;
    gradientDirection?: 'to-t' | 'to-tr' | 'to-r' | 'to-br' | 'to-b' | 'to-bl' | 'to-l' | 'to-tl';
    gradientFromColor?: string;
    gradientToColor?: string;
}
