import type gsap from 'gsap';
import type { ScrollTrigger } from 'gsap/ScrollTrigger';

export interface MarketingMotionContext {
    gsap: typeof gsap;
    ScrollTrigger: typeof ScrollTrigger;
}

export async function runMarketingMotion(
    setup: (
        context: MarketingMotionContext,
    ) => void | (() => void) | Promise<void | (() => void)>,
): Promise<() => void> {
    if (
        typeof window === 'undefined' ||
        window.matchMedia('(prefers-reduced-motion: reduce)').matches
    ) {
        return () => {};
    }

    const [{ default: gsap }, { ScrollTrigger }] = await Promise.all([
        import('gsap'),
        import('gsap/ScrollTrigger'),
    ]);

    gsap.registerPlugin(ScrollTrigger);

    const cleanup = await setup({ gsap, ScrollTrigger });

    return () => {
        if (typeof cleanup === 'function') {
            cleanup();
        }

        ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
    };
}
