<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted } from 'vue';
import AppHead from '@/components/AppHead.vue';
import AigstLayout from '@/layouts/AigstLayout.vue';
import { runMarketingMotion } from '@/lib/marketingMotion';

defineProps<{ canRegister?: boolean }>();

const page = usePage();

const structuredData = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'Restaurant',
    name: 'Indian Grocery & Takeout',
    image: 'https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/Kulcha.jpg/:/rs=w:600,h:600,cg:true',
    servesCuisine: 'Indian',
    telephone: '+1-519-305-3663',
    address: {
        '@type': 'PostalAddress',
        streetAddress: '1020 Ontario St',
        addressLocality: 'Stratford',
        addressRegion: 'ON',
        postalCode: 'N5A 3J1',
        addressCountry: 'CA',
    },
    url:
        ((page.props.seo as { baseUrl?: string } | undefined)?.baseUrl ??
            'http://localhost') + '/',
}));

let cleanupAnimations: (() => void) | undefined;

onMounted(async () => {
    cleanupAnimations = await runMarketingMotion(({ gsap, ScrollTrigger }) => {
        const ease = 'power3.out';

        const tl = gsap.timeline({ defaults: { ease, duration: 0.9 } });
        tl.from('.hero-eyebrow', { y: 20, opacity: 0 })
            .from('.hero h1', { y: 30, opacity: 0 }, '-=0.5')
            .from('.hero-desc', { y: 20, opacity: 0 }, '-=0.5')
            .from('.hero-btns', { y: 20, opacity: 0 }, '-=0.6')
            .from('.hero-stat', { y: 20, opacity: 0, stagger: 0.1 }, '-=0.5')
            .from(
                '.hero-blob',
                {
                    scale: 0,
                    opacity: 0,
                    transformOrigin: 'center',
                    duration: 1,
                    ease: 'back.out(1.4)',
                },
                '-=1.2',
            )
            .from(
                '.hero-img',
                { scale: 0.6, opacity: 0, duration: 1, ease: 'back.out(1.4)' },
                '-=0.9',
            )
            .from(
                '.chip-a',
                { x: -30, y: 20, opacity: 0, duration: 0.6 },
                '-=0.4',
            )
            .from(
                '.chip-b',
                { x: 30, y: -20, opacity: 0, duration: 0.6 },
                '-=0.5',
            );

        gsap.to('.chip-a', {
            y: '+=10',
            duration: 2.5,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 2,
        });
        gsap.to('.chip-b', {
            y: '-=10',
            duration: 2.8,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 2,
        });

        document
            .querySelectorAll<HTMLElement>('.hero-stat strong[data-count]')
            .forEach((el) => {
                const target = parseInt(el.dataset.count ?? '0', 10);
                const prefix = el.dataset.prefix ?? '';
                const suffix = el.dataset.suffix ?? '';
                const obj = { v: 0 };
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top 90%',
                    once: true,
                    onEnter: () =>
                        gsap.to(obj, {
                            v: target,
                            duration: 1.6,
                            ease: 'power2.out',
                            onUpdate: () => {
                                el.textContent =
                                    prefix + Math.round(obj.v) + suffix;
                            },
                        }),
                });
            });

        gsap.from('.why-img-anim', {
            scale: 1.15,
            opacity: 0,
            duration: 1.2,
            ease,
            scrollTrigger: {
                trigger: '.why-imgwrap',
                start: 'top 85%',
                once: true,
            },
        });
        gsap.from('.why-badge', {
            scale: 0,
            opacity: 0,
            duration: 0.7,
            ease: 'back.out(1.7)',
            scrollTrigger: {
                trigger: '.why-imgwrap',
                start: 'top 75%',
                once: true,
            },
        });
        gsap.from('.strip-item', {
            y: 10,
            opacity: 0,
            duration: 0.6,
            ease,
            stagger: 0.08,
            scrollTrigger: { trigger: '.strip', start: 'top 95%', once: true },
        });
        gsap.from('.catpill', {
            y: 16,
            opacity: 0,
            duration: 0.5,
            ease,
            stagger: 0.08,
            scrollTrigger: {
                trigger: '.cater-banner',
                start: 'top 80%',
                once: true,
            },
        });

        document.querySelectorAll<HTMLElement>('.dish-card').forEach((card) => {
            const img = card.querySelector('img');
            if (!img) {
                return;
            }

            card.addEventListener('mouseenter', () =>
                gsap.to(img, { scale: 1.06, duration: 0.5, ease }),
            );
            card.addEventListener('mouseleave', () =>
                gsap.to(img, { scale: 1, duration: 0.5, ease }),
            );
        });
    });
});

onBeforeUnmount(() => {
    cleanupAnimations?.();
});
</script>

<template>
    <AppHead
        title="Authentic Indian Food in Stratford"
        description="Indian Grocery & Takeout serves fresh North Indian food, Amritsari kulcha, curries, catering, and party trays in Stratford, Ontario."
        :keywords="[
            'Indian restaurant Stratford',
            'Indian food Stratford',
            'catering Stratford',
            'party trays Stratford',
        ]"
        :structured-data="structuredData"
    />
    <AigstLayout active="home">
        <section class="hero">
            <div class="hero-bg"></div>
            <div class="hero-inner">
                <div>
                    <div class="hero-eyebrow">
                        Stratford's Favourite Indian Kitchen
                    </div>
                    <h1>
                        Real.<br /><em>Authentic.</em><br />Fresh Indian Food.
                    </h1>
                    <p class="hero-desc">
                        Handcrafted North Indian flavours made fresh every day —
                        from our famous Amritsari Kulcha to slow-cooked curries
                        and tandoori specialties.
                    </p>
                    <div class="hero-btns">
                        <Link href="/menu" prefetch class="btn btn-primary"
                            >Explore Menu</Link
                        >
                        <Link
                            href="/catering"
                            prefetch
                            class="btn btn-secondary"
                            >Catering &amp; Events</Link
                        >
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <strong data-count="1" data-prefix="#">#1</strong>
                            <span>Kulcha in Stratford</span>
                        </div>
                        <div class="hero-stat">
                            <strong data-count="50" data-suffix="+">50+</strong>
                            <span>Fresh menu items</span>
                        </div>
                        <div class="hero-stat">
                            <strong data-count="80" data-suffix="+">80+</strong>
                            <span>People per event</span>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="hero-blob"></div>
                    <img
                        class="hero-img"
                        src="https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/Kulcha.jpg/:/rs=w:600,h:600,cg:true"
                        alt="Amritsari Kulcha"
                        width="600"
                        height="600"
                        fetchpriority="high"
                        decoding="async"
                    />
                    <div class="chip chip-a">
                        <span style="font-size: 20px">⭐</span>
                        <div>
                            <strong>Best Seller</strong
                            ><small>Amritsari Kulcha Meal</small>
                        </div>
                    </div>
                    <div class="chip chip-b">
                        <span style="font-size: 20px">🍃</span>
                        <div>
                            <strong>Always Fresh</strong
                            ><small>Made to order daily</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="strip">
            <div class="strip-inner">
                <div class="strip-item">
                    <div class="sdot"></div>
                    Open Daily 11am – 8pm
                </div>
                <div class="strip-item">
                    <div class="sdot"></div>
                    1020 Ontario St, Stratford ON
                </div>
                <div class="strip-item">
                    <div class="sdot"></div>
                    <a href="tel:15193053663" style="color: inherit"
                        >519-305-3663</a
                    >
                </div>
                <div class="strip-item">
                    <div class="sdot"></div>
                    Dine In · Takeout · Delivery
                </div>
            </div>
        </div>

        <div style="background: var(--cream-white); padding: 80px 0">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 32px">
                <div class="section-label reveal">Fan Favourites</div>
                <div
                    style="
                        display: flex;
                        align-items: flex-end;
                        justify-content: space-between;
                        flex-wrap: wrap;
                        gap: 16px;
                        margin-bottom: 48px;
                    "
                >
                    <h2 class="section-title reveal" style="margin-bottom: 0">
                        Most <span>Popular</span> Dishes
                    </h2>
                    <Link
                        href="/menu"
                        prefetch
                        class="btn btn-secondary reveal"
                        style="font-size: 14px; padding: 10px 22px"
                        >View Full Menu →</Link
                    >
                </div>
                <div class="dishes-grid">
                    <div class="dish-card reveal-stagger">
                        <img
                            src="https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/Kulcha.jpg/:/rs=w:500,h:380,cg:true"
                            alt="Amritsari Kulcha Meal"
                            width="500"
                            height="380"
                            loading="lazy"
                            decoding="async"
                        />
                        <div class="dish-info">
                            <div
                                style="
                                    display: flex;
                                    gap: 6px;
                                    margin-bottom: 8px;
                                "
                            >
                                <span class="badge badge-veg">Veg</span>
                                <span class="badge badge-bestseller"
                                    >⭐ #1 Seller</span
                                >
                            </div>
                            <h3>Amritsari Kulcha Meal</h3>
                            <p>
                                Dhaba-style layered bread with butter &amp;
                                spices, served with authentic chole.
                            </p>
                            <div class="dish-foot">
                                <span class="dprice">$12.99</span>
                                <Link
                                    href="/menu"
                                    prefetch
                                    class="btn btn-primary"
                                    style="font-size: 13px; padding: 8px 18px"
                                    >Order</Link
                                >
                            </div>
                        </div>
                    </div>
                    <div class="dish-card reveal-stagger">
                        <img
                            src="https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/chicken%20biryani.jpg/:/rs=w:500,h:380,cg:true"
                            alt="Chicken Biryani"
                            width="500"
                            height="380"
                            loading="lazy"
                            decoding="async"
                        />
                        <div class="dish-info">
                            <div
                                style="
                                    display: flex;
                                    gap: 6px;
                                    margin-bottom: 8px;
                                "
                            >
                                <span class="badge badge-nonveg">Non-Veg</span>
                            </div>
                            <h3>Chicken Biryani</h3>
                            <p>
                                Basmati rice with chicken, saffron, mint and
                                rose water.
                            </p>
                            <div class="dish-foot">
                                <span class="dprice">$15.99</span>
                                <Link
                                    href="/menu"
                                    prefetch
                                    class="btn btn-primary"
                                    style="font-size: 13px; padding: 8px 18px"
                                    >Order</Link
                                >
                            </div>
                        </div>
                    </div>
                    <div class="dish-card reveal-stagger">
                        <img
                            src="https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/chicken-karahi-1.jpg/:/rs=w:500,h:380,cg:true"
                            alt="Karahi Chicken"
                            width="500"
                            height="380"
                            loading="lazy"
                            decoding="async"
                        />
                        <div class="dish-info">
                            <div
                                style="
                                    display: flex;
                                    gap: 6px;
                                    margin-bottom: 8px;
                                "
                            >
                                <span class="badge badge-nonveg">Non-Veg</span>
                            </div>
                            <h3>Karahi Chicken</h3>
                            <p>
                                Chicken cooked with julienne peppers in classic
                                karahi masala sauce.
                            </p>
                            <div class="dish-foot">
                                <span class="dprice">$13.99</span>
                                <Link
                                    href="/menu"
                                    prefetch
                                    class="btn btn-primary"
                                    style="font-size: 13px; padding: 8px 18px"
                                    >Order</Link
                                >
                            </div>
                        </div>
                    </div>
                    <div class="dish-card reveal-stagger">
                        <div class="dish-ph">Palak Paneer Photo</div>
                        <div class="dish-info">
                            <div
                                style="
                                    display: flex;
                                    gap: 6px;
                                    margin-bottom: 8px;
                                "
                            >
                                <span class="badge badge-veg">Veg</span>
                            </div>
                            <h3>Palak Paneer</h3>
                            <p>
                                Cottage cheese in fresh spinach, butter, cream
                                and spices.
                            </p>
                            <div class="dish-foot">
                                <span class="dprice">$11.99</span>
                                <Link
                                    href="/menu"
                                    prefetch
                                    class="btn btn-primary"
                                    style="font-size: 13px; padding: 8px 18px"
                                    >Order</Link
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="why-section">
            <div style="max-width: 1200px; margin: 0 auto; padding: 80px 32px">
                <div class="why-grid">
                    <div class="why-imgwrap">
                        <img
                            class="why-img-anim"
                            src="https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/chicken-karahi-1.jpg/:/rs=w:600,h:800,cg:true"
                            alt="Fresh Indian Cooking"
                            width="600"
                            height="800"
                            loading="lazy"
                            decoding="async"
                        />
                        <div class="why-badge">
                            <strong>100%</strong>
                            <span>Authentic Spices</span>
                        </div>
                    </div>
                    <div>
                        <div class="section-label reveal">
                            Why Customers Love Us
                        </div>
                        <h2 class="section-title reveal">
                            Real <span>Ingredients.</span><br />Real Flavour.
                        </h2>
                        <p class="section-sub reveal">
                            We bring the honest, bold taste of North India to
                            your table — no shortcuts, no compromises.
                        </p>
                        <div class="why-feats">
                            <div class="wfeat reveal-stagger">
                                <div class="wfeat-icon">🌶️</div>
                                <div>
                                    <h4>Authentic Spice Blends</h4>
                                    <p>
                                        Every dish uses traditional Indian spice
                                        blends — sweet, mild, or fiery hot, your
                                        way.
                                    </p>
                                </div>
                            </div>
                            <div class="wfeat reveal-stagger">
                                <div class="wfeat-icon">🫓</div>
                                <div>
                                    <h4>True Amritsari Kulcha</h4>
                                    <p>
                                        Our kulcha is made the true Amritsar way
                                        — layered, buttered and baked fresh in
                                        our kitchen.
                                    </p>
                                </div>
                            </div>
                            <div class="wfeat reveal-stagger">
                                <div class="wfeat-icon">🎉</div>
                                <div>
                                    <h4>Catering for Every Occasion</h4>
                                    <p>
                                        From 10-person office lunches to 80+
                                        guest celebrations — we've got you
                                        covered.
                                    </p>
                                </div>
                            </div>
                            <div class="wfeat reveal-stagger">
                                <div class="wfeat-icon">🚚</div>
                                <div>
                                    <h4>Delivery Available</h4>
                                    <p>
                                        Order on Skip the Dishes or DoorDash and
                                        enjoy fresh Indian food at your
                                        doorstep.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div style="padding: 80px 32px; background: var(--cream)">
            <div style="max-width: 1200px; margin: 0 auto">
                <div class="cater-banner reveal-scale">
                    <div>
                        <div
                            style="
                                font-size: 12px;
                                font-weight: 700;
                                letter-spacing: 0.1em;
                                text-transform: uppercase;
                                color: var(--gold);
                                margin-bottom: 12px;
                            "
                        >
                            Celebrations &amp; Corporate Events
                        </div>
                        <h2>Catering That Makes Your Event Unforgettable</h2>
                        <p>
                            We serve celebrations, anniversaries, birthday
                            parties, baby showers, corporate meetings and more —
                            from 10 to 80+ people. Sit back and enjoy while we
                            handle the food.
                        </p>
                        <div class="catpills">
                            <div class="catpill">Basic · $10.99/pp</div>
                            <div class="catpill">Green · $12.99/pp</div>
                            <div class="catpill">Non-Veg · $14.99/pp</div>
                            <div class="catpill">Supreme · $18.99/pp</div>
                        </div>
                        <div
                            style="
                                margin-top: 28px;
                                display: flex;
                                gap: 12px;
                                flex-wrap: wrap;
                            "
                        >
                            <Link
                                href="/catering"
                                prefetch
                                class="btn btn-primary"
                                style="
                                    background: var(--gold);
                                    color: var(--text);
                                "
                                >View Packages</Link
                            >
                            <Link
                                href="/contact"
                                prefetch
                                class="btn btn-secondary"
                                style="
                                    background: rgba(255, 255, 255, 0.12);
                                    color: white;
                                    border-color: rgba(255, 255, 255, 0.3);
                                "
                                >Contact Us</Link
                            >
                        </div>
                    </div>
                    <div class="pricebox">
                        <div class="from">Starting From</div>
                        <div class="amt">$10</div>
                        <div class="per">.99 / person</div>
                        <Link
                            href="/catering"
                            prefetch
                            class="btn"
                            style="
                                background: var(--gold);
                                color: var(--text);
                                font-size: 14px;
                                padding: 12px 24px;
                            "
                            >See Packages</Link
                        >
                    </div>
                </div>
            </div>
        </div>

        <div style="background: var(--cream-white); padding: 80px 0">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 32px">
                <div class="section-label reveal">What People Are Saying</div>
                <h2 class="section-title reveal">Customer <span>Love</span></h2>
                <div class="reviews-grid">
                    <div class="rcard reveal-stagger">
                        <div class="rstars">★★★★★</div>
                        <p>
                            "The Amritsari Kulcha is absolutely incredible —
                            layers of flavour, perfectly buttered. Best Indian
                            food in Stratford by a mile!"
                        </p>
                        <div class="rauthor">
                            <div class="ravatar">P</div>
                            <div>
                                <div class="rname">Priya S.</div>
                                <div class="rloc">Stratford, ON</div>
                            </div>
                        </div>
                    </div>
                    <div class="rcard reveal-stagger">
                        <div class="rstars">★★★★★</div>
                        <p>
                            "We used them for our company lunch — 30 people. The
                            food was hot, fresh and everyone was raving. Will
                            definitely book again!"
                        </p>
                        <div class="rauthor">
                            <div class="ravatar">M</div>
                            <div>
                                <div class="rname">Michael T.</div>
                                <div class="rloc">
                                    Corporate Client, Stratford
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rcard reveal-stagger">
                        <div class="rstars">★★★★★</div>
                        <p>
                            "Ordered the Karahi Chicken and Dal Makhani — rich,
                            authentic flavours just like home. The party tray
                            service for my daughter's birthday was perfect!"
                        </p>
                        <div class="rauthor">
                            <div class="ravatar">A</div>
                            <div>
                                <div class="rname">Amanpreet K.</div>
                                <div class="rloc">Stratford, ON</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-section">
            <h2 class="reveal">Order Online, Anytime</h2>
            <p class="reveal">
                Fresh Indian food delivered to your door — available on Skip the
                Dishes and DoorDash.
            </p>
            <div class="olinks">
                <a
                    href="https://www.skipthedishes.com/indian-grocery-and-takeout-ontario-st"
                    target="_blank"
                    class="olink reveal-stagger"
                >
                    <span class="olink-icon">🛵</span> Order on Skip the Dishes
                </a>
                <a
                    href="https://www.doordash.com/store/indian-grocery-&-takeout-stratford-25962964/"
                    target="_blank"
                    class="olink reveal-stagger"
                >
                    <span class="olink-icon">🚗</span> Order on DoorDash
                </a>
                <a href="tel:15193053663" class="olink reveal-stagger">
                    <span class="olink-icon">📞</span> Call or WhatsApp Us
                </a>
            </div>
        </div>
    </AigstLayout>
</template>
