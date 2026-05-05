<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted } from 'vue';
import AppHead from '@/components/AppHead.vue';
import AigstLayout from '@/layouts/AigstLayout.vue';
import { runMarketingMotion } from '@/lib/marketingMotion';

interface TrayRow {
    name: string;
    sHalf: string;
    half: string;
    full: string;
}
interface TraySection {
    icon: string;
    title: string;
    badge?: { label: string; type: 'veg' | 'nonveg' };
    rows: TrayRow[];
}

const traySections: TraySection[] = [
    {
        icon: '🥘',
        title: 'Vegetarian Curries',
        badge: { label: 'Veg', type: 'veg' },
        rows: [
            { name: 'Dal Makhani', sHalf: '$35', half: '$65', full: '$120' },
            { name: 'Karahi Paneer', sHalf: '$35', half: '$65', full: '$120' },
            {
                name: 'Paneer Tikka Masala',
                sHalf: '$35',
                half: '$65',
                full: '$120',
            },
            {
                name: 'Butter Paneer Masala',
                sHalf: '$30',
                half: '$60',
                full: '$110',
            },
            { name: 'Palak Paneer', sHalf: '$30', half: '$60', full: '$110' },
            { name: 'Shahi Paneer', sHalf: '$30', half: '$60', full: '$110' },
            { name: 'Mix Vegetable', sHalf: '$35', half: '$65', full: '$110' },
            { name: 'Chana Masala', sHalf: '$30', half: '$60', full: '$110' },
        ],
    },
    {
        icon: '🍗',
        title: 'Non-Vegetarian Curries',
        badge: { label: 'Non-Veg', type: 'nonveg' },
        rows: [
            {
                name: 'Butter Chicken Masala',
                sHalf: '$35',
                half: '$65',
                full: '$120',
            },
            {
                name: 'Chicken Tikka Masala',
                sHalf: '$40',
                half: '$75',
                full: '$135',
            },
            { name: 'Butter Chicken', sHalf: '$35', half: '$65', full: '$120' },
            { name: 'Karahi Chicken', sHalf: '$40', half: '$75', full: '$135' },
        ],
    },
    {
        icon: '🍚',
        title: 'Rice',
        rows: [
            {
                name: 'Zeera (Cumin) Rice',
                sHalf: '$15',
                half: '$30',
                full: '$55',
            },
            { name: 'Veg Biryani', sHalf: '$25', half: '$45', full: '$80' },
            {
                name: 'Chicken Biryani',
                sHalf: '$35',
                half: '$60',
                full: '$100',
            },
            { name: 'Veg Fried Rice', sHalf: '$20', half: '$35', full: '$65' },
            {
                name: 'Chicken Fried Rice',
                sHalf: '$30',
                half: '$55',
                full: '$90',
            },
        ],
    },
];

interface AppetCard {
    name: string;
    note: string;
    price: string;
    callUs?: boolean;
}

const appetizers: AppetCard[] = [
    { name: 'Paneer Tikka', note: '30 pieces', price: '$60' },
    { name: 'Chicken Tikka', note: '30 pieces', price: '$60' },
    { name: 'Malai Tikka', note: '30 pieces', price: '$60' },
    { name: 'Fish Tikka', note: '30 pieces', price: '$60' },
    { name: 'Tandoori Full Leg', note: '20 pieces', price: '$90' },
    {
        name: 'Mix Pakore',
        note: 'Contact for pricing',
        price: 'Call Us',
        callUs: true,
    },
    {
        name: 'Paneer Pakore',
        note: 'Contact for pricing',
        price: 'Call Us',
        callUs: true,
    },
    {
        name: 'Amritsari Fish Fry',
        note: 'Contact for pricing',
        price: 'Call Us',
        callUs: true,
    },
];

const sweets: AppetCard[] = [
    { name: 'Gulab Jamun', note: '30 pieces', price: '$30' },
    { name: 'Rasmalai', note: '30 pieces', price: '$55' },
    {
        name: 'Moong Dal Halwa',
        note: 'By tray — contact for pricing',
        price: 'Call Us',
        callUs: true,
    },
];

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

        gsap.from('.size-legend', {
            y: 30,
            opacity: 0,
            duration: 0.8,
            ease,
            scrollTrigger: {
                trigger: '.size-legend',
                start: 'top bottom-=40',
                once: true,
            },
        });

        document
            .querySelectorAll<HTMLElement>('.tray-section')
            .forEach((section) => {
                const headings = section.querySelectorAll<HTMLElement>('h2');
                const rows = section.querySelectorAll<HTMLElement>(
                    '.tray-table tbody tr',
                );
                const cards =
                    section.querySelectorAll<HTMLElement>('.appet-card');

                if (headings.length > 0) {
                    gsap.from(headings, {
                        x: -30,
                        opacity: 0,
                        duration: 0.7,
                        ease,
                        scrollTrigger: {
                            trigger: section,
                            start: 'top bottom-=40',
                            once: true,
                        },
                    });
                }

                if (rows.length > 0) {
                    gsap.from(rows, {
                        y: 20,
                        opacity: 0,
                        duration: 0.5,
                        ease,
                        stagger: 0.04,
                        scrollTrigger: {
                            trigger: section,
                            start: 'top bottom-=40',
                            once: true,
                        },
                    });
                }

                if (cards.length > 0) {
                    gsap.from(cards, {
                        y: 30,
                        opacity: 0,
                        duration: 0.6,
                        ease,
                        stagger: 0.06,
                        scrollTrigger: {
                            trigger: section,
                            start: 'top bottom-=40',
                            once: true,
                        },
                    });
                }
            });

        gsap.from('.order-note', {
            y: 30,
            opacity: 0,
            duration: 0.8,
            ease,
            scrollTrigger: {
                trigger: '.order-note',
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
        title="Indian Party Trays in Stratford"
        description="Order Indian party trays in Stratford with vegetarian curries, chicken dishes, biryani, appetizers, and desserts for family events and office gatherings."
        path="/party-trays"
    />
    <AigstLayout active="trays">
        <section class="page-hero orange">
            <div class="page-hero-inner">
                <div
                    class="section-label"
                    style="color: rgba(255, 255, 255, 0.7)"
                >
                    Feed the Crowd
                </div>
                <h1>Party Trays</h1>
                <p>
                    Order by the tray — perfect for parties, events and
                    gatherings. Available in three sizes to suit any group size.
                </p>
            </div>
        </section>

        <div style="max-width: 1200px; margin: 0 auto; padding: 64px 32px 80px">
            <div class="size-legend">
                <h4>Tray Sizes:</h4>
                <div class="size-chip">
                    S.Half <span>Shallow Half Tray (10"×12"×1.5")</span>
                </div>
                <div class="size-chip">
                    Half <span>Deep Half Tray (10"×12"×2.5")</span>
                </div>
                <div class="size-chip">Full <span>Full Large Tray</span></div>
            </div>

            <div style="margin-top: 56px">
                <div
                    v-for="(section, idx) in traySections"
                    :key="idx"
                    class="tray-section"
                >
                    <h2>
                        <div class="tray-icon">{{ section.icon }}</div>
                        {{ section.title }}
                        <span
                            v-if="section.badge"
                            class="badge"
                            :class="
                                section.badge.type === 'veg'
                                    ? 'badge-veg'
                                    : 'badge-nonveg'
                            "
                            style="font-size: 12px"
                            >{{ section.badge.label }}</span
                        >
                    </h2>
                    <table class="tray-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>S. Half</th>
                                <th>Half</th>
                                <th>Full</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in section.rows" :key="row.name">
                                <td>{{ row.name }}</td>
                                <td>{{ row.sHalf }}</td>
                                <td>{{ row.half }}</td>
                                <td>{{ row.full }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tray-section">
                    <h2>
                        <div class="tray-icon">🔥</div>
                        Appetizers &amp; Tandoori
                    </h2>
                    <div class="appet-grid">
                        <div
                            v-for="card in appetizers"
                            :key="card.name"
                            class="appet-card"
                        >
                            <div>
                                <div class="appet-name">{{ card.name }}</div>
                                <div class="appet-note">{{ card.note }}</div>
                            </div>
                            <div
                                class="appet-price"
                                :style="
                                    card.callUs
                                        ? 'color:var(--text-muted);font-size:14px;'
                                        : ''
                                "
                            >
                                {{ card.price }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tray-section">
                    <h2>
                        <div class="tray-icon">🍮</div>
                        Sweets
                    </h2>
                    <div class="appet-grid">
                        <div
                            v-for="card in sweets"
                            :key="card.name"
                            class="appet-card"
                        >
                            <div>
                                <div class="appet-name">{{ card.name }}</div>
                                <div class="appet-note">{{ card.note }}</div>
                            </div>
                            <div
                                class="appet-price"
                                :style="
                                    card.callUs
                                        ? 'color:var(--text-muted);font-size:14px;'
                                        : ''
                                "
                            >
                                {{ card.price }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-note">
                    <strong>How to Order Party Trays:</strong> Contact us at
                    least 24–48 hours in advance. Call us at
                    <a href="tel:15193053663">519-305-3663</a>, message us on
                    <a href="https://wa.me/16474471046" target="_blank"
                        >WhatsApp</a
                    >, or use our
                    <Link href="/contact" prefetch>contact form</Link>. We'll
                    confirm your order and advise on quantities for your group
                    size.
                </div>

                <div
                    style="
                        margin-top: 40px;
                        display: flex;
                        gap: 12px;
                        flex-wrap: wrap;
                    "
                >
                    <Link href="/contact" prefetch class="btn btn-primary"
                        >📋 Place a Party Tray Order</Link
                    >
                    <Link href="/catering" prefetch class="btn btn-secondary"
                        >View Catering Packages →</Link
                    >
                </div>
            </div>
        </div>
    </AigstLayout>
</template>
