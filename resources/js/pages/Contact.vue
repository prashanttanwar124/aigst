<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue';
import AppHead from '@/components/AppHead.vue';
import AigstLayout from '@/layouts/AigstLayout.vue';
import { runMarketingMotion } from '@/lib/marketingMotion';

const submitted = ref(false);
const form = ref({
    fname: '',
    lname: '',
    email: '',
    phone: '',
    enquiry: '',
    eventDate: '',
    guests: '',
    message: '',
});
let cleanupAnimations: (() => void) | undefined;

function handleSubmit() {
    submitted.value = true;
    gsap.fromTo(
        '.success-msg',
        { y: 10, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.5, ease: 'power3.out' },
    );
}

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

        gsap.from('.contact-info > h2', {
            y: 20,
            opacity: 0,
            duration: 0.7,
            ease,
            scrollTrigger: {
                trigger: '.contact-info',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.info-card', {
            x: -30,
            opacity: 0,
            duration: 0.6,
            ease,
            stagger: 0.1,
            scrollTrigger: {
                trigger: '.contact-info',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.hours-table', {
            y: 30,
            opacity: 0,
            duration: 0.7,
            ease,
            scrollTrigger: {
                trigger: '.hours-table',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.map-placeholder', {
            y: 30,
            opacity: 0,
            duration: 0.7,
            ease,
            scrollTrigger: {
                trigger: '.map-placeholder',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.form-card', {
            x: 40,
            opacity: 0,
            duration: 0.9,
            ease,
            scrollTrigger: {
                trigger: '.form-card',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.form-card .form-group, .form-card .form-row', {
            y: 20,
            opacity: 0,
            duration: 0.5,
            ease,
            stagger: 0.06,
            scrollTrigger: {
                trigger: '.form-card',
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
        title="Contact Indian Grocery & Takeout"
        description="Contact Indian Grocery & Takeout in Stratford for catering bookings, party tray orders, directions, hours, and delivery information."
        path="/contact"
    />
    <AigstLayout active="contact">
        <section class="page-hero cream">
            <div class="page-hero-inner">
                <div class="section-label">Get in Touch</div>
                <h1>Contact Us</h1>
                <p>
                    Whether you want to place a catering order, ask about party
                    trays, or just say hi — we'd love to hear from you.
                </p>
            </div>
        </section>

        <div class="contact-body">
            <div class="contact-info">
                <h2>Find Us</h2>

                <div class="info-card">
                    <div class="info-icon">📍</div>
                    <div>
                        <h4>Our Location</h4>
                        <p>1020 Ontario St<br />Stratford, ON N5A 3J1</p>
                        <a
                            href="https://maps.google.com/?q=1020+Ontario+St+Stratford+ON"
                            target="_blank"
                            style="font-size: 13px"
                            >Get Directions →</a
                        >
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">📞</div>
                    <div>
                        <h4>Phone</h4>
                        <p><a href="tel:15193053663">519-305-3663</a></p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">💬</div>
                    <div>
                        <h4>WhatsApp</h4>
                        <p>
                            <a href="https://wa.me/16474471046" target="_blank"
                                >+1 (647) 447-1046</a
                            ><br />
                            <span
                                style="
                                    font-size: 13px;
                                    color: var(--text-muted);
                                "
                                >Quick replies for catering &amp; party tray
                                orders</span
                            >
                        </p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">🛵</div>
                    <div>
                        <h4>Order for Delivery</h4>
                        <p>
                            <a
                                href="https://www.skipthedishes.com/indian-grocery-and-takeout-ontario-st"
                                target="_blank"
                                >Order on Skip the Dishes</a
                            ><br />
                            <a
                                href="https://www.doordash.com/store/indian-grocery-&-takeout-stratford-25962964/"
                                target="_blank"
                                >Order on DoorDash</a
                            >
                        </p>
                    </div>
                </div>

                <div class="hours-table">
                    <h4>🕐 Opening Hours</h4>
                    <div class="hours-row">
                        <span class="day">Monday – Sunday</span>
                        <span class="time">11:00 am – 8:00 pm</span>
                    </div>
                    <div
                        style="
                            margin-top: 12px;
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            font-size: 13px;
                            color: var(--text-muted);
                        "
                    >
                        <span class="open-badge">● Open Now</span> We're open
                        every day of the week
                    </div>
                </div>

                <div class="map-placeholder">
                    <span style="font-size: 32px">📌</span>
                    <strong>1020 Ontario St, Stratford ON</strong>
                    <a
                        href="https://maps.google.com/?q=1020+Ontario+St+Stratford+ON"
                        target="_blank"
                        >Open in Google Maps →</a
                    >
                </div>
            </div>

            <div>
                <div class="form-card">
                    <h2>Send Us a Message</h2>
                    <p>
                        For catering bookings, party tray orders or general
                        enquiries — fill out this form and we'll get back to you
                        shortly.
                    </p>
                    <form @submit.prevent="handleSubmit">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fname">First Name *</label>
                                <input
                                    type="text"
                                    id="fname"
                                    v-model="form.fname"
                                    placeholder="Priya"
                                    required
                                    :disabled="submitted"
                                />
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name *</label>
                                <input
                                    type="text"
                                    id="lname"
                                    v-model="form.lname"
                                    placeholder="Singh"
                                    required
                                    :disabled="submitted"
                                />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input
                                    type="email"
                                    id="email"
                                    v-model="form.email"
                                    placeholder="you@example.com"
                                    required
                                    :disabled="submitted"
                                />
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input
                                    type="tel"
                                    id="phone"
                                    v-model="form.phone"
                                    placeholder="519-555-0100"
                                    :disabled="submitted"
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="enquiry">Enquiry Type *</label>
                            <select
                                id="enquiry"
                                v-model="form.enquiry"
                                required
                                :disabled="submitted"
                            >
                                <option value="">Select a topic…</option>
                                <option>Catering Booking</option>
                                <option>Party Tray Order</option>
                                <option>General Question</option>
                                <option>Menu Question</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="event-date"
                                >Event Date (if applicable)</label
                            >
                            <input
                                type="date"
                                id="event-date"
                                v-model="form.eventDate"
                                :disabled="submitted"
                            />
                        </div>
                        <div class="form-group">
                            <label for="guests"
                                >Number of Guests (if applicable)</label
                            >
                            <input
                                type="number"
                                id="guests"
                                v-model="form.guests"
                                placeholder="e.g. 30"
                                min="1"
                                :disabled="submitted"
                            />
                        </div>
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea
                                id="message"
                                v-model="form.message"
                                placeholder="Tell us about your event, dietary requirements, or any questions…"
                                required
                                :disabled="submitted"
                            ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="btn btn-primary form-submit"
                            :disabled="submitted"
                        >
                            Send Message →
                        </button>
                        <div v-if="submitted" class="success-msg">
                            ✅ Thank you! We'll be in touch within 24 hours.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AigstLayout>
</template>
