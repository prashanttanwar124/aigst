<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { runMarketingMotion } from '@/lib/marketingMotion';
import '../../css/aigst.css';

defineProps<{
    active?: 'home' | 'menu' | 'catering' | 'trays' | 'contact';
}>();

const drawerOpen = ref(false);
let cleanupAnimations: (() => void) | undefined;

function toggleDrawer() {
    drawerOpen.value = !drawerOpen.value;
}
function closeDrawer() {
    drawerOpen.value = false;
}
watch(drawerOpen, (open) => {
    document.body.style.overflow = open ? 'hidden' : '';
});

onMounted(async () => {
    cleanupAnimations = await runMarketingMotion(
        async ({ gsap, ScrollTrigger }) => {
            const ease = 'power3.out';
            await nextTick();

            gsap.from('.aigst nav', {
                y: -60,
                opacity: 0,
                duration: 0.6,
                ease,
            });

            gsap.utils.toArray<HTMLElement>('.reveal').forEach((el) => {
                gsap.from(el, {
                    y: 40,
                    opacity: 0,
                    duration: 0.9,
                    ease,
                    scrollTrigger: {
                        trigger: el,
                        start: 'top bottom-=40',
                        once: true,
                    },
                });
            });

            const groups = new Map<Element, HTMLElement[]>();
            document
                .querySelectorAll<HTMLElement>('.reveal-stagger')
                .forEach((el) => {
                    const parent = el.parentElement!;
                    if (!groups.has(parent)) {
                        groups.set(parent, []);
                    }

                    groups.get(parent)!.push(el);
                });

            groups.forEach((items) => {
                gsap.from(items, {
                    y: 50,
                    opacity: 0,
                    duration: 0.8,
                    ease,
                    stagger: 0.1,
                    scrollTrigger: {
                        trigger: items[0],
                        start: 'top bottom-=40',
                        once: true,
                    },
                });
            });

            gsap.utils.toArray<HTMLElement>('.reveal-scale').forEach((el) => {
                gsap.from(el, {
                    scale: 0.92,
                    opacity: 0,
                    duration: 1,
                    ease,
                    scrollTrigger: {
                        trigger: el,
                        start: 'top bottom-=40',
                        once: true,
                    },
                });
            });

            ScrollTrigger.refresh();
        },
    );
});

onBeforeUnmount(() => {
    cleanupAnimations?.();
});
</script>

<template>
    <div class="aigst">
        <nav>
            <div class="nav-inner">
                <Link href="/" prefetch class="nav-logo">
                    <span class="logo-top">Indian Grocery</span>
                    <span class="logo-sub">&amp; Takeout · Stratford, ON</span>
                </Link>
                <ul class="nav-links">
                    <li>
                        <Link
                            href="/"
                            prefetch
                            :class="{ active: active === 'home' }"
                            >Home</Link
                        >
                    </li>
                    <li>
                        <Link
                            href="/menu"
                            prefetch
                            :class="{ active: active === 'menu' }"
                            >Menu</Link
                        >
                    </li>
                    <li>
                        <Link
                            href="/catering"
                            prefetch
                            :class="{ active: active === 'catering' }"
                            >Catering</Link
                        >
                    </li>
                    <li>
                        <Link
                            href="/party-trays"
                            prefetch
                            :class="{ active: active === 'trays' }"
                            >Party Trays</Link
                        >
                    </li>
                    <li>
                        <Link
                            href="/contact"
                            prefetch
                            :class="{ active: active === 'contact' }"
                            >Contact</Link
                        >
                    </li>
                    <li>
                        <a
                            href="https://www.skipthedishes.com/indian-grocery-and-takeout-ontario-st"
                            target="_blank"
                            class="nav-cta"
                            >Order Online</a
                        >
                    </li>
                </ul>
                <button
                    class="nav-burger"
                    :class="{ open: drawerOpen }"
                    aria-label="Open menu"
                    @click="toggleDrawer"
                >
                    <span></span><span></span><span></span>
                </button>
            </div>
        </nav>

        <!-- MOBILE DRAWER -->
        <div
            class="nav-drawer-backdrop"
            :class="{ open: drawerOpen }"
            @click="closeDrawer"
        ></div>
        <aside class="nav-drawer" :class="{ open: drawerOpen }">
            <div class="nav-drawer-head">
                <div>
                    <span class="logo-top">Indian Grocery</span><br />
                    <span class="logo-sub">&amp; Takeout · Stratford, ON</span>
                </div>
                <button
                    class="nav-drawer-close"
                    aria-label="Close"
                    @click="closeDrawer"
                >
                    ✕
                </button>
            </div>
            <ul class="nav-drawer-links">
                <li>
                    <Link
                        href="/"
                        prefetch
                        :class="{ active: active === 'home' }"
                        @click="closeDrawer"
                        ><span>🏠</span> Home</Link
                    >
                </li>
                <li>
                    <Link
                        href="/menu"
                        prefetch
                        :class="{ active: active === 'menu' }"
                        @click="closeDrawer"
                        ><span>📖</span> Menu</Link
                    >
                </li>
                <li>
                    <Link
                        href="/catering"
                        prefetch
                        :class="{ active: active === 'catering' }"
                        @click="closeDrawer"
                        ><span>🎉</span> Catering</Link
                    >
                </li>
                <li>
                    <Link
                        href="/party-trays"
                        prefetch
                        :class="{ active: active === 'trays' }"
                        @click="closeDrawer"
                        ><span>🍱</span> Party Trays</Link
                    >
                </li>
                <li>
                    <Link
                        href="/contact"
                        prefetch
                        :class="{ active: active === 'contact' }"
                        @click="closeDrawer"
                        ><span>📞</span> Contact</Link
                    >
                </li>
            </ul>
            <div class="nav-drawer-cta">
                <a
                    href="https://www.skipthedishes.com/indian-grocery-and-takeout-ontario-st"
                    target="_blank"
                    class="btn btn-primary"
                    style="width: 100%; justify-content: center"
                    >🛵 Order Online</a
                >
                <a
                    href="tel:15193053663"
                    class="btn btn-secondary"
                    style="
                        width: 100%;
                        justify-content: center;
                        margin-top: 10px;
                    "
                    >📞 519-305-3663</a
                >
            </div>
        </aside>

        <slot />

        <footer class="footer">
            <div class="footer-grid">
                <div class="fbrand">
                    <strong>Indian Grocery &amp; Takeout</strong>
                    <p>
                        Bringing the bold, honest flavours of North India to
                        Stratford, Ontario. Family run, always fresh.
                    </p>
                </div>
                <div class="fcol">
                    <h4>Pages</h4>
                    <ul>
                        <li><Link href="/" prefetch>Home</Link></li>
                        <li><Link href="/menu" prefetch>Menu</Link></li>
                        <li><Link href="/catering" prefetch>Catering</Link></li>
                        <li>
                            <Link href="/party-trays" prefetch
                                >Party Trays</Link
                            >
                        </li>
                        <li><Link href="/contact" prefetch>Contact</Link></li>
                    </ul>
                </div>
                <div class="fcol">
                    <h4>Order Online</h4>
                    <ul>
                        <li>
                            <a
                                href="https://www.skipthedishes.com/indian-grocery-and-takeout-ontario-st"
                                target="_blank"
                                >Skip the Dishes</a
                            >
                        </li>
                        <li>
                            <a
                                href="https://www.doordash.com/store/indian-grocery-&-takeout-stratford-25962964/"
                                target="_blank"
                                >DoorDash</a
                            >
                        </li>
                    </ul>
                </div>
                <div class="fcol">
                    <h4>Visit Us</h4>
                    <p class="txt">
                        1020 Ontario St<br />Stratford, ON<br /><br />Open
                        Daily<br />11:00am – 8:00pm<br /><br />📞
                        <a href="tel:15193053663" style="color: var(--gold)"
                            >519-305-3663</a
                        ><br />💬
                        <a
                            href="https://wa.me/16474471046"
                            target="_blank"
                            style="color: var(--gold)"
                            >WhatsApp</a
                        >
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© 2025 Indian Grocery &amp; Takeout, Stratford ON</span>
                <span>Made with ❤️ for authentic Indian food lovers</span>
            </div>
        </footer>
    </div>
</template>
