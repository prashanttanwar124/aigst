<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted } from 'vue';
import AppHead from '@/components/AppHead.vue';
import AigstLayout from '@/layouts/AigstLayout.vue';
import { runMarketingMotion } from '@/lib/marketingMotion';

let cleanupAnimations: (() => void) | undefined;

onMounted(async () => {
    cleanupAnimations = await runMarketingMotion(({ gsap, ScrollTrigger }) => {
        const ease = 'power3.out';

        gsap.from('.page-hero .section-label, .page-hero h1, .page-hero p', {
            y: 30,
            opacity: 0,
            duration: 0.8,
            ease,
            stagger: 0.12,
        });

        gsap.from('.occasion-card', {
            opacity: 0,
            duration: 0.5,
            ease,
            stagger: 0.15,
            scrollTrigger: {
                trigger: '.occasion-grid',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.how-step', {
            y: 40,
            opacity: 0,
            duration: 0.7,
            ease,
            stagger: 0.12,
            scrollTrigger: {
                trigger: '.how-grid',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.how-num', {
            scale: 0,
            duration: 0.6,
            ease: 'back.out(1.7)',
            stagger: 0.15,
            scrollTrigger: {
                trigger: '.how-grid',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.cta-contact', {
            scale: 0.95,
            opacity: 0,
            duration: 1,
            ease,
            scrollTrigger: {
                trigger: '.cta-contact',
                start: 'top bottom-=40',
                once: true,
            },
        });

        ScrollTrigger.refresh();
    });
});

onBeforeUnmount(() => {
    cleanupAnimations?.();
});
</script>

<template>
    <AppHead
        title="Indian Catering in Stratford"
        description="Book Indian catering in Stratford for celebrations, office lunches, birthdays, weddings, and corporate events with vegetarian and non-vegetarian packages."
        path="/catering"
    />
    <AigstLayout active="catering">
        <section class="page-hero dark">
            <div class="page-hero-inner">
                <div class="section-label" style="color: var(--gold)">
                    Celebrations &amp; Corporate
                </div>
                <h1>Catering That Makes Every<br />Occasion Unforgettable</h1>
                <p>
                    We serve everything from intimate family gatherings to large
                    corporate events — 10 to 80+ people. Sit back, relax and
                    enjoy your special day while we handle the food.
                </p>
            </div>
        </section>

        <div style="max-width: 1200px; margin: 0 auto; padding: 80px 32px">
            <div class="section-label reveal">Who We Cater For</div>
            <h2 class="section-title reveal">
                Every <span>Occasion</span> Covered
            </h2>
            <div class="occasion-grid">
                <div class="occasion-card">
                    <div class="occasion-img-ph">🎉</div>
                    <div class="occasion-body">
                        <div class="occasion-icon">🎊</div>
                        <h3>Celebrations</h3>
                        <p>
                            Anniversaries, baby showers, birthdays, engagements
                            and family events. Give your loved ones an authentic
                            Indian dining experience they'll never forget. Our
                            team caters to all taste preferences — sweet, mild,
                            spicy or hot.
                        </p>
                        <div class="occasion-tags">
                            <span class="tag">Anniversaries</span>
                            <span class="tag">Baby Showers</span>
                            <span class="tag">Birthdays</span>
                            <span class="tag">Engagements</span>
                            <span class="tag">Family Events</span>
                        </div>
                    </div>
                </div>
                <div class="occasion-card">
                    <div class="occasion-img-ph">🏢</div>
                    <div class="occasion-body">
                        <div class="occasion-icon">💼</div>
                        <h3>Corporate Events</h3>
                        <p>
                            Corporate parties, meetings, team building sessions
                            and long weekends. We offer a range of snacks,
                            sweets, lunch and dinner catering. Serving all kinds
                            of meetings — from 10 people to major events with
                            80+ guests.
                        </p>
                        <div class="occasion-tags">
                            <span class="tag">Corporate Parties</span>
                            <span class="tag">Team Meetings</span>
                            <span class="tag">Team Building</span>
                            <span class="tag">Long Weekends</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="pkg-section">
            <div style="max-width: 1200px; margin: 0 auto; padding: 80px 32px">
                <div class="section-label" style="color: var(--gold)">
                    Packages
                </div>
                <div
                    style="
                        display: flex;
                        align-items: flex-end;
                        justify-content: space-between;
                        flex-wrap: wrap;
                        gap: 16px;
                    "
                >
                    <h2
                        class="section-title"
                        style="color: white; margin-bottom: 0"
                    >
                        Choose Your
                        <span style="color: var(--gold)">Package</span>
                    </h2>
                    <p style="color: rgba(255, 255, 255, 0.6); font-size: 15px">
                        All packages include Tandoori Naan &amp; Boondi Raita
                    </p>
                </div>

                <div class="pkgs-grid">
                    <div class="pkg-card">
                        <div class="pkg-label">Basic</div>
                        <div class="pkg-name">Basic Package</div>
                        <div class="pkg-price">
                            $10<span style="font-size: 1.2rem">.99</span>
                        </div>
                        <div class="pkg-per">per person</div>
                        <div class="pkg-divider"></div>
                        <div class="pkg-items-label">6 Vegetarian Items</div>
                        <div class="pkg-feat">
                            3 Veg Curries (1 Paneer + 2 regular)
                        </div>
                        <div class="pkg-feat">
                            Dal Makhani, Chana Masala, Dal Tadka
                        </div>
                        <div class="pkg-feat">
                            Palak, Shahi or Butter Paneer
                        </div>
                        <div class="pkg-feat">Mix Vegetable</div>
                        <div class="pkg-feat">Rice (Zeera or Mattar Pulao)</div>
                        <div class="pkg-cta">
                            <Link
                                href="/contact"
                                prefetch="click"
                                class="btn btn-secondary"
                                style="
                                    font-size: 14px;
                                    padding: 10px 20px;
                                    background: rgba(255, 255, 255, 0.1);
                                    color: white;
                                    border-color: rgba(255, 255, 255, 0.2);
                                    width: 100%;
                                    justify-content: center;
                                "
                                >Book Now</Link
                            >
                        </div>
                    </div>

                    <div class="pkg-card">
                        <div class="pkg-label">Green</div>
                        <div class="pkg-name">Green Package</div>
                        <div class="pkg-price">
                            $12<span style="font-size: 1.2rem">.99</span>
                        </div>
                        <div class="pkg-per">per person</div>
                        <div class="pkg-divider"></div>
                        <div class="pkg-items-label">8 Vegetarian Items</div>
                        <div class="pkg-feat">
                            Starter — Samosa, Onion Bhajji or Pakore
                        </div>
                        <div class="pkg-feat">
                            3 Veg Curries (1 Paneer + 2 regular)
                        </div>
                        <div class="pkg-feat">Rice (Zeera or Mattar Pulao)</div>
                        <div class="pkg-feat">
                            Dessert — Halwa, Gulab Jamun or Gajrella
                        </div>
                        <div class="pkg-cta">
                            <Link
                                href="/contact"
                                prefetch="click"
                                class="btn btn-secondary"
                                style="
                                    font-size: 14px;
                                    padding: 10px 20px;
                                    background: rgba(255, 255, 255, 0.1);
                                    color: white;
                                    border-color: rgba(255, 255, 255, 0.2);
                                    width: 100%;
                                    justify-content: center;
                                "
                                >Book Now</Link
                            >
                        </div>
                    </div>

                    <div class="pkg-card featured">
                        <div class="pkg-label">Most Popular</div>
                        <div class="pkg-name">Non-Veg Package</div>
                        <div class="pkg-price">
                            $14<span style="font-size: 1.2rem">.99</span>
                        </div>
                        <div class="pkg-per">per person</div>
                        <div
                            class="pkg-divider"
                            style="background: rgba(255, 255, 255, 0.2)"
                        ></div>
                        <div class="pkg-items-label">8 Items</div>
                        <div class="pkg-feat">
                            Starter — Samosa, Bhajji or Pakore
                        </div>
                        <div class="pkg-feat">2 Veg Curries (your choice)</div>
                        <div class="pkg-feat">
                            1 Non-Veg Curry — Butter Chicken, Karahi Chicken or
                            Tikka Masala
                        </div>
                        <div class="pkg-feat">Rice + Dessert</div>
                        <div class="pkg-cta">
                            <Link
                                href="/contact"
                                prefetch="click"
                                class="btn"
                                style="
                                    font-size: 14px;
                                    padding: 10px 20px;
                                    background: white;
                                    color: var(--orange);
                                    font-weight: 700;
                                    width: 100%;
                                    justify-content: center;
                                "
                                >Book Now</Link
                            >
                        </div>
                    </div>

                    <div class="pkg-card">
                        <div class="pkg-label">Premium</div>
                        <div class="pkg-name">Supreme Package</div>
                        <div class="pkg-price">
                            $18<span style="font-size: 1.2rem">.99</span>
                        </div>
                        <div class="pkg-per">per person</div>
                        <div class="pkg-divider"></div>
                        <div class="pkg-items-label">10 Items</div>
                        <div class="pkg-feat">
                            2 Starters — Samosa, Bhajji, Paneer Pakore, Fish Fry
                            or Soya Chaap
                        </div>
                        <div class="pkg-feat">
                            2 Veg Curries + 1 Non-Veg Curry
                        </div>
                        <div class="pkg-feat">
                            1 Tandoori — Chicken Tikka or Malai Tikka
                        </div>
                        <div class="pkg-feat">Rice + Dessert</div>
                        <div class="pkg-cta">
                            <Link
                                href="/contact"
                                prefetch="click"
                                class="btn btn-secondary"
                                style="
                                    font-size: 14px;
                                    padding: 10px 20px;
                                    background: rgba(255, 255, 255, 0.1);
                                    color: white;
                                    border-color: rgba(255, 255, 255, 0.2);
                                    width: 100%;
                                    justify-content: center;
                                "
                                >Book Now</Link
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div style="max-width: 1200px; margin: 0 auto; padding: 80px 32px">
            <div class="section-label reveal">How It Works</div>
            <h2 class="section-title reveal">
                Simple <span>Booking</span> Process
            </h2>
            <div class="how-grid">
                <div class="how-step">
                    <div class="how-num">1</div>
                    <h4>Contact Us</h4>
                    <p>
                        Reach out by phone, WhatsApp or our contact form with
                        your event details.
                    </p>
                </div>
                <div class="how-step">
                    <div class="how-num">2</div>
                    <h4>Choose Package</h4>
                    <p>
                        Pick a catering package and customize your menu items
                        from our selection.
                    </p>
                </div>
                <div class="how-step">
                    <div class="how-num">3</div>
                    <h4>We Confirm</h4>
                    <p>
                        We'll confirm your booking, headcount and any dietary
                        requirements.
                    </p>
                </div>
                <div class="how-step">
                    <div class="how-num">4</div>
                    <h4>Enjoy Your Event</h4>
                    <p>
                        Sit back and enjoy — we handle everything so you can
                        relax with your guests.
                    </p>
                </div>
            </div>
        </div>

        <div style="padding: 0 0 80px">
            <div class="cta-contact">
                <div>
                    <div class="section-label">Ready to Book?</div>
                    <h2>Let's Plan Your Event Together</h2>
                    <p>
                        Contact us in advance to book your date. Our team will
                        work with you on your perfect menu — any spice level,
                        any dietary requirement.
                    </p>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <Link
                        href="/contact"
                        prefetch="click"
                        class="btn btn-primary"
                        style="justify-content: center"
                        >📋 Send Enquiry</Link
                    >
                    <a
                        href="tel:15193053663"
                        class="btn btn-secondary"
                        style="justify-content: center"
                        >📞 519-305-3663</a
                    >
                    <a
                        href="https://wa.me/16474471046"
                        target="_blank"
                        class="btn btn-green"
                        style="justify-content: center"
                        >💬 WhatsApp Us</a
                    >
                </div>
            </div>
        </div>
    </AigstLayout>
</template>
