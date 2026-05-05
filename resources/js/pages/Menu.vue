<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import AppHead from '@/components/AppHead.vue';
import AigstLayout from '@/layouts/AigstLayout.vue';
import { runMarketingMotion } from '@/lib/marketingMotion';

type FoodType = 'veg' | 'nonveg';

interface Item {
    name: string;
    desc?: string;
    price?: string;
    sizes?: { reg: string; large: string };
    perPiece?: boolean;
    badge?: string;
    type: FoodType;
    emoji: string;
    image?: string;
    spice?: 0 | 1 | 2 | 3;
}
interface Cat {
    id: string;
    icon: string;
    title: string;
    note?: string;
    badge?: { label: string; type: FoodType };
    items: Item[];
}

const KULCHA =
    'https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/Kulcha.jpg/:/rs=w:200,h:200,cg:true';
const BIRYANI =
    'https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/chicken%20biryani.jpg/:/rs=w:200,h:200,cg:true';
const KARAHI =
    'https://img1.wsimg.com/isteam/ip/a16fa987-4cb1-4963-8164-4897040feb46/chicken-karahi-1.jpg/:/rs=w:200,h:200,cg:true';

const cats: Cat[] = [
    {
        id: 'kulcha',
        icon: '🫓',
        title: 'Kulcha & Specials',
        note: "Our signature dishes — don't miss these!",
        items: [
            {
                name: 'Amritsari Kulcha Meal',
                desc: 'Our #1 best seller. Take our best vegetarian dish along with our #1 bread — the Amritsari Kulcha.',
                price: '$12.99',
                badge: '⭐ Best Seller',
                type: 'veg',
                emoji: '🫓',
                image: KULCHA,
                spice: 1,
            },
            {
                name: 'Amritsari Kulcha with Butter',
                desc: 'Made in the true Amritsar tradition! Layered bread, softened with butter and garnished with spices.',
                price: '$7.99',
                type: 'veg',
                emoji: '🫓',
                image: KULCHA,
                spice: 0,
            },
            {
                name: 'Chole Bhature',
                desc: 'Chickpeas cooked in authentic spice, served with a puffy Indian bread called a Bhatura.',
                price: '$10.99',
                type: 'veg',
                emoji: '🍛',
                spice: 2,
            },
            {
                name: 'Extra Bhatura',
                desc: 'Deep fried naan bread.',
                price: '$1.99',
                type: 'veg',
                emoji: '🥖',
                spice: 0,
            },
            {
                name: 'Pav Bhajji',
                desc: 'Thick vegetable curry prepared in butter and served with soft bread roll.',
                price: '$8.99',
                type: 'veg',
                emoji: '🍔',
                spice: 1,
            },
        ],
    },
    {
        id: 'chaat',
        icon: '🍡',
        title: 'Chaat & Street Food',
        note: 'Bold, tangy North Indian street snacks',
        items: [
            {
                name: 'Pani Puri',
                desc: 'Crisp-fried spheres filled with ragda and authentic spiced water.',
                price: '$7.99',
                type: 'veg',
                emoji: '🥟',
                spice: 2,
            },
            {
                name: 'Samosa Chaat',
                desc: 'Crispy warm potato-stuffed patties topped with spicy chickpeas, chilled yogurt and tangy chutneys.',
                price: '$7.99',
                type: 'veg',
                emoji: '🥧',
                spice: 2,
            },
            {
                name: 'Aloo Tikki Chaat',
                desc: 'A crispy Indian potato patty flavoured with spices, topped with yogurt and chutneys.',
                price: '$7.99',
                type: 'veg',
                emoji: '🥔',
                spice: 1,
            },
            {
                name: 'Chat Papdi',
                desc: 'Crispy flakes mixed in chickpeas, potatoes & chutney.',
                price: '$7.99',
                type: 'veg',
                emoji: '🥗',
                spice: 1,
            },
            {
                name: 'Sev Puri',
                desc: 'Puri loaded with diced potatoes, chickpeas, onions with mixed chutney and sev.',
                price: '$7.99',
                type: 'veg',
                emoji: '🌮',
                spice: 1,
            },
            {
                name: 'Masala Papad',
                desc: 'Fried papad garnished with chopped onions, tomatoes and fresh coriander.',
                price: '$2.49',
                type: 'veg',
                emoji: '🍘',
                spice: 1,
            },
            {
                name: 'Samosa',
                desc: 'Deep fried pastry with a spiced filling made with potatoes, spices and herbs.',
                price: '$0.99',
                perPiece: true,
                type: 'veg',
                emoji: '🥟',
                spice: 1,
            },
        ],
    },
    {
        id: 'pakora',
        icon: '🧆',
        title: 'Pakoras & Snacks',
        items: [
            {
                name: 'Paneer Pakora Box',
                price: '$10.99',
                type: 'veg',
                emoji: '🧆',
                spice: 1,
            },
            {
                name: 'Onion Bhajji Box',
                price: '$7.49',
                type: 'veg',
                emoji: '🧅',
                spice: 1,
            },
            {
                name: 'Mix Veg Pakora Box',
                price: '$8.49',
                type: 'veg',
                emoji: '🥦',
                spice: 1,
            },
        ],
    },
    {
        id: 'veg',
        icon: '🥘',
        title: 'Main Course',
        badge: { label: 'Vegetarian', type: 'veg' },
        note: 'Regular $11.99 · Large $13.99',
        items: [
            {
                name: 'Dal Makhani',
                desc: 'Slow simmered black lentils cooked with cream, butter, ginger-garlic, tomatoes and spices.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'veg',
                emoji: '🍲',
                spice: 1,
            },
            {
                name: 'Palak Paneer',
                desc: 'Cottage cheese cooked with fresh spinach, butter, cream and spices.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'veg',
                emoji: '🥬',
                spice: 1,
            },
            {
                name: 'Shahi Paneer',
                desc: 'Paneer chunks in a thick creamy gravy prepared in tomato cashew paste.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'veg',
                emoji: '🧀',
                spice: 1,
            },
            {
                name: 'Butter Paneer Masala',
                desc: 'Paneer cooked with butter masala sauce.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'veg',
                emoji: '🧈',
                spice: 1,
            },
            {
                name: 'Paneer Tikka Masala',
                desc: 'Chunks of paneer tossed with bell peppers and onions in rich tomato and masala sauce.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'veg',
                emoji: '🌶️',
                spice: 2,
            },
            {
                name: 'Karahi Paneer',
                desc: 'Paneer cooked with typical north frontier karahi sauce and spices.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'veg',
                emoji: '🍳',
                spice: 2,
            },
            {
                name: 'Mix Vegetable',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'veg',
                emoji: '🥗',
                spice: 1,
            },
            {
                name: 'Chana Masala',
                desc: 'Chickpeas cooked with a delicious blend of Indian spices, onions and tomatoes.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'veg',
                emoji: '🫘',
                spice: 2,
            },
        ],
    },
    {
        id: 'nonveg',
        icon: '🍗',
        title: 'Main Course',
        badge: { label: 'Non-Vegetarian', type: 'nonveg' },
        note: 'Add extra meat for only $2.49',
        items: [
            {
                name: 'Butter Chicken',
                desc: 'Chicken cooked in butter gravy.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'nonveg',
                emoji: '🍗',
                image: KARAHI,
                spice: 1,
            },
            {
                name: 'Butter Chicken Masala',
                desc: 'Chicken cooked in a butter masala sauce.',
                sizes: { reg: '$11.99', large: '$13.99' },
                type: 'nonveg',
                emoji: '🍗',
                spice: 2,
            },
            {
                name: 'Chicken Tikka Masala',
                desc: 'Chicken cooked with diced green peppers and onions in a tikka masala sauce.',
                sizes: { reg: '$13.99', large: '$15.99' },
                type: 'nonveg',
                emoji: '🌶️',
                spice: 2,
            },
            {
                name: 'Karahi Chicken',
                desc: 'Chicken cooked with julienne cut green pepper and onions in masala sauce.',
                sizes: { reg: '$13.99', large: '$15.99' },
                type: 'nonveg',
                emoji: '🍳',
                image: KARAHI,
                spice: 2,
            },
            {
                name: 'Chicken Curry (Desi Style)',
                desc: 'Chicken stewed in an onion and tomato based sauce, flavored with ginger, garlic and spices.',
                sizes: { reg: '$12.99', large: '$14.99' },
                type: 'nonveg',
                emoji: '🍲',
                spice: 2,
            },
            {
                name: 'Goat Curry',
                desc: 'Tender pieces of goat meat cooked with yogurt and aromatic spices.',
                sizes: { reg: '$15.99', large: '$17.99' },
                type: 'nonveg',
                emoji: '🍖',
                spice: 2,
            },
            {
                name: 'Lamb Curry',
                desc: 'Tender pieces of lamb meat cooked with yogurt and aromatic spices.',
                sizes: { reg: '$15.99', large: '$17.99' },
                type: 'nonveg',
                emoji: '🍖',
                spice: 2,
            },
            {
                name: 'Kadhai Lamb',
                desc: 'Lamb cooked with julienne cut green pepper and onions in masala sauce and karahi spices.',
                sizes: { reg: '$15.99', large: '$17.99' },
                type: 'nonveg',
                emoji: '🍖',
                spice: 3,
            },
        ],
    },
    {
        id: 'tandoori',
        icon: '🔥',
        title: 'Tandoori Items',
        note: 'Marinated and baked in our traditional tandoor oven',
        items: [
            {
                name: 'Paneer Tikka Box',
                desc: 'Cubes of paneer marinated in yogurt and spices, grilled in the tandoor.',
                price: '$13.99',
                badge: 'Veg',
                type: 'veg',
                emoji: '🧀',
                spice: 2,
            },
            {
                name: 'Tandoori Masala Soy Chaap Box',
                desc: 'Marinated soya chop grilled in the tandoor.',
                price: '$10.99',
                type: 'veg',
                emoji: '🌱',
                spice: 2,
            },
            {
                name: 'Chicken Tikka Box',
                desc: "Tender pieces of chicken marinated in chef's special marination and broiled in tandoor.",
                price: '$15.99',
                type: 'nonveg',
                emoji: '🍗',
                spice: 2,
            },
            {
                name: 'Chicken Malai Tikka Box',
                desc: 'Melt-in-mouth chicken breast marinated in cashew creamy marination, grilled in tandoor.',
                price: '$15.99',
                type: 'nonveg',
                emoji: '🍗',
                spice: 1,
            },
            {
                name: 'Tandoori Fish Tikka Box',
                desc: 'Basa fish marinated in exotic tandoori spices and baked slowly in tandoori oven.',
                price: '$14.99',
                type: 'nonveg',
                emoji: '🐟',
                spice: 2,
            },
            {
                name: 'Tandoori Chicken Full Leg',
                desc: 'Chicken leg+thigh marinated in tandoori spices and baked slowly in tandoori oven.',
                price: '$5.49',
                type: 'nonveg',
                emoji: '🍗',
                spice: 2,
            },
        ],
    },
    {
        id: 'bread',
        icon: '🫘',
        title: 'Breads & Naan',
        items: [
            {
                name: 'Tandoori Roti',
                desc: 'Whole-wheat tandoor baked bread.',
                price: '$1.99',
                type: 'veg',
                emoji: '🫓',
                spice: 0,
            },
            {
                name: 'Tandoori Naan',
                desc: 'Leavened white flour tandoori bread.',
                price: '$1.99',
                type: 'veg',
                emoji: '🫓',
                spice: 0,
            },
            {
                name: 'Butter Naan',
                desc: 'Leavened white flour tandoori bread brushed with butter.',
                price: '$3.49',
                type: 'veg',
                emoji: '🧈',
                spice: 0,
            },
            {
                name: 'Garlic Naan',
                desc: 'Leavened bread topped with freshly chopped garlic.',
                price: '$2.99',
                type: 'veg',
                emoji: '🧄',
                spice: 0,
            },
            {
                name: 'Masala Naan',
                desc: 'Spiced up naan — try it if you like it hot!',
                price: '$3.99',
                type: 'veg',
                emoji: '🌶️',
                spice: 2,
            },
        ],
    },
    {
        id: 'rice',
        icon: '🍚',
        title: 'Rice & Biryani',
        items: [
            {
                name: 'Zeera (Cumin) Rice',
                desc: 'Boiled basmati rice with cumin seeds flavoured with whole spices.',
                price: '$4.99',
                badge: 'Veg',
                type: 'veg',
                emoji: '🍚',
                spice: 0,
            },
            {
                name: 'Veg Biryani',
                desc: 'Basmati rice cooked with stir-fried vegetables, flavored with mint and biryani spices.',
                price: '$10.99',
                type: 'veg',
                emoji: '🍚',
                spice: 1,
            },
            {
                name: 'Chicken Biryani',
                desc: 'Basmati rice cooked with chicken, flavored with mint, saffron and rose water.',
                price: '$15.99',
                type: 'nonveg',
                emoji: '🍗',
                image: BIRYANI,
                spice: 1,
            },
            {
                name: 'Lamb Biryani',
                desc: 'Basmati rice cooked with lamb, flavored with mint, saffron and rose water.',
                price: '$17.99',
                type: 'nonveg',
                emoji: '🍖',
                spice: 1,
            },
        ],
    },
    {
        id: 'sides',
        icon: '🥗',
        title: 'Sides',
        items: [
            {
                name: 'Imli Pyaaz Chutney',
                desc: 'Authentic dhaba style. Goes great with Amritsari Kulcha!',
                price: '$0.99',
                perPiece: true,
                type: 'veg',
                emoji: '🧅',
                spice: 1,
            },
            {
                name: 'Sweet Tamarind Chutney',
                price: '$0.50',
                perPiece: true,
                type: 'veg',
                emoji: '🍯',
                spice: 0,
            },
            {
                name: 'Mint Chutney',
                price: '$0.50',
                perPiece: true,
                type: 'veg',
                emoji: '🌿',
                spice: 1,
            },
            {
                name: 'Boondi Raita',
                price: '$3.99',
                type: 'veg',
                emoji: '🥛',
                spice: 0,
            },
        ],
    },
    {
        id: 'drinks',
        icon: '🥤',
        title: 'Drinks',
        items: [
            {
                name: 'Kadak Masala Tea',
                desc: 'Indian style strong Chai Tea.',
                price: '$2.49',
                type: 'veg',
                emoji: '🍵',
                spice: 0,
            },
            {
                name: 'Dudh Patti',
                price: '$2.99',
                type: 'veg',
                emoji: '🥛',
                spice: 0,
            },
            {
                name: 'Milk Badam',
                desc: 'A nutritious drink — milk with a blend of nuts flavoured with saffron.',
                price: '$5.99',
                type: 'veg',
                emoji: '🥛',
                spice: 0,
            },
            {
                name: 'Mango Shake',
                price: '$5.99',
                type: 'veg',
                emoji: '🥭',
                spice: 0,
            },
            {
                name: 'Mango Lassi',
                price: '$5.99',
                type: 'veg',
                emoji: '🥭',
                spice: 0,
            },
            {
                name: 'Royal Falooda',
                price: '$7.99',
                type: 'veg',
                emoji: '🍨',
                spice: 0,
            },
            {
                name: 'Masala Soda',
                price: '$4.99',
                type: 'veg',
                emoji: '🥤',
                spice: 0,
            },
            {
                name: 'Mojito Soda',
                price: '$4.99',
                type: 'veg',
                emoji: '🥤',
                spice: 0,
            },
            { name: 'Pop', price: '$1.99', type: 'veg', emoji: '🥤', spice: 0 },
            {
                name: 'Water Bottle',
                price: '$0.99',
                type: 'veg',
                emoji: '💧',
                spice: 0,
            },
        ],
    },
];

const sidebar = [
    { heading: 'Starters', links: ['kulcha', 'chaat', 'pakora'] },
    { heading: 'Mains', links: ['veg', 'nonveg'] },
    { heading: 'Tandoori', links: ['tandoori'] },
    { heading: 'Breads & Rice', links: ['bread', 'rice'] },
    { heading: 'Sides & Drinks', links: ['sides', 'drinks'] },
];

const sidebarLabels: Record<string, string> = {
    kulcha: 'Kulcha & Specials',
    chaat: 'Chaat & Street Food',
    pakora: 'Pakoras & Snacks',
    veg: 'Veg Main Course',
    nonveg: 'Non-Veg Main Course',
    tandoori: 'Tandoori Items',
    bread: 'Breads / Naan',
    rice: 'Rice & Biryani',
    sides: 'Sides',
    drinks: 'Drinks',
};

const processSteps = [
    {
        num: 1,
        emoji: '🌾',
        title: 'Fresh Ingredients',
        desc: 'Hand-picked spices, paneer & vegetables sourced fresh daily.',
    },
    {
        num: 2,
        emoji: '👨‍🍳',
        title: 'Slow-Cooked',
        desc: 'Traditional dhaba-style techniques — every curry simmers for hours.',
    },
    {
        num: 3,
        emoji: '🔥',
        title: 'Tandoor Fired',
        desc: 'Naan, kulcha & tandoori items baked in our authentic clay tandoor.',
    },
    {
        num: 4,
        emoji: '🍽️',
        title: 'Served Hot',
        desc: 'Plated and packed at the moment of order — flavour locked in.',
    },
];

const heroSpotlight = {
    name: 'Amritsari Kulcha Meal',
    image: KULCHA,
    price: '$12.99',
    note: 'Crisp kulcha, Punjabi comfort, and the easiest first pick when someone opens the menu for the first time.',
    type: 'veg' as FoodType,
    target: 'kulcha',
};

const quickJumps = [
    { label: 'Best Seller', target: 'kulcha', emoji: '⭐' },
    { label: 'Veg Curries', target: 'veg', emoji: '🟢' },
    { label: 'Chicken Favourites', target: 'nonveg', emoji: '🍗' },
    { label: 'Biryani', target: 'rice', emoji: '🍚' },
    { label: 'Tandoori', target: 'tandoori', emoji: '🔥' },
    { label: 'Drinks', target: 'drinks', emoji: '🥤' },
];

const heroGallery = [
    {
        name: 'Chicken Biryani',
        image: BIRYANI,
        target: 'rice',
        eyebrow: 'Aromatic rice',
        note: 'Layered, filling, and easy to share.',
    },
    {
        name: 'Karahi Chicken',
        image: KARAHI,
        target: 'nonveg',
        eyebrow: 'House favourite',
        note: 'Bold masala with rich wok-style heat.',
    },
];

const activeCat = ref<string>('kulcha');
const filterType = ref<'all' | 'veg' | 'nonveg'>('all');
const search = ref('');
const fabOpen = ref(false);
const showBackToTop = ref(false);

const totalCounts = computed(() => {
    let total = 0,
        veg = 0,
        nonveg = 0;
    cats.forEach((c) => {
        c.items.forEach((i) => {
            total++;
            if (i.type === 'veg') veg++;
            else nonveg++;
        });
    });
    return { total, veg, nonveg };
});

const sidebarCounts = computed(() => {
    const counts: Record<string, number> = {};
    filteredCats.value.forEach((c) => {
        counts[c.id] = c.items.length;
    });
    return counts;
});

function waOrder(name: string) {
    const msg = encodeURIComponent(`Hi! I'd like to order: ${name}`);
    return `https://wa.me/16474471046?text=${msg}`;
}

function scrollTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

const filteredCats = computed(() => {
    const q = search.value.trim().toLowerCase();
    return cats
        .map((cat) => ({
            ...cat,
            items: cat.items.filter((item) => {
                if (
                    filterType.value !== 'all' &&
                    item.type !== filterType.value
                )
                    return false;
                if (
                    q &&
                    !item.name.toLowerCase().includes(q) &&
                    !item.desc?.toLowerCase().includes(q)
                )
                    return false;
                return true;
            }),
        }))
        .filter((cat) => cat.items.length > 0);
});

const noResults = computed(() => filteredCats.value.length === 0);
const hasActiveFilters = computed(
    () => filterType.value !== 'all' || search.value.trim().length > 0,
);
const visibleItemCount = computed(() =>
    filteredCats.value.reduce(
        (total, category) => total + category.items.length,
        0,
    ),
);

function clearFilters() {
    filterType.value = 'all';
    search.value = '';
}

function jumpTo(id: string) {
    const el = document.getElementById(id);
    if (!el) return;
    window.scrollTo({
        top: el.getBoundingClientRect().top + window.scrollY - 140,
        behavior: 'smooth',
    });
    activeCat.value = id;
}

function scrollTo(id: string, e: Event) {
    e.preventDefault();
    jumpTo(id);
}

let onScroll: (() => void) | null = null;
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

        gsap.from('.process-step', {
            opacity: 0,
            duration: 0.45,
            ease,
            stagger: 0.1,
            scrollTrigger: {
                trigger: '.process-section',
                start: 'top bottom-=40',
                once: true,
            },
        });

        gsap.from('.menu-toolbar', {
            y: -10,
            opacity: 0,
            duration: 0.6,
            ease,
            scrollTrigger: {
                trigger: '.menu-toolbar',
                start: 'top bottom-=20',
                once: true,
            },
        });

        document.querySelectorAll<HTMLElement>('.menu-cat').forEach((cat) => {
            const head = cat.querySelector<HTMLElement>('.cat-head');
            const items = cat.querySelectorAll<HTMLElement>('.item-row');
            if (head) {
                gsap.from(head, {
                    x: -30,
                    opacity: 0,
                    duration: 0.6,
                    ease,
                    scrollTrigger: {
                        trigger: cat,
                        start: 'top bottom-=40',
                        once: true,
                    },
                });
            }

            if (items.length > 0) {
                gsap.from(items, {
                    y: 30,
                    opacity: 0,
                    duration: 0.5,
                    ease,
                    stagger: 0.04,
                    scrollTrigger: {
                        trigger: cat,
                        start: 'top bottom-=40',
                        once: true,
                    },
                });
            }
        });

        ScrollTrigger.refresh();
    });

    const catEls = () => document.querySelectorAll<HTMLElement>('.menu-cat');
    onScroll = () => {
        showBackToTop.value = window.scrollY > 600;
        const list = catEls();
        if (list.length === 0) return;
        let current = list[0].id;
        list.forEach((c) => {
            if (c.getBoundingClientRect().top <= 160) current = c.id;
        });
        if (current !== activeCat.value) {
            activeCat.value = current;
            const pill = document.querySelector<HTMLElement>(
                `.mobile-cat-pill[data-target="${current}"]`,
            );
            const bar = document.querySelector<HTMLElement>('.mobile-cat-bar');
            if (pill && bar) {
                bar.scrollTo({
                    left:
                        pill.offsetLeft -
                        bar.clientWidth / 2 +
                        pill.clientWidth / 2,
                    behavior: 'smooth',
                });
            }
        }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
});

onBeforeUnmount(() => {
    if (onScroll) {
        window.removeEventListener('scroll', onScroll);
    }

    cleanupAnimations?.();
});
</script>

<template>
    <AppHead
        title="Indian Restaurant Menu in Stratford"
        description="Browse the Indian Grocery & Takeout menu in Stratford with kulcha, curries, biryani, street food, tandoori dishes, and vegetarian options."
        path="/menu"
    />
    <AigstLayout active="menu">
        <section class="page-hero green-flat">
            <div class="page-hero-inner">
                <div class="menu-hero-grid">
                    <div class="menu-hero-copy">
                        <div class="menu-hero-eyebrow">
                            <span class="section-label">Fresh Daily</span>
                            <span class="menu-hero-note"
                                >Made for fast phone ordering</span
                            >
                        </div>
                        <h1>Find the right dish fast.</h1>
                        <p>
                            Explore vegetarian favourites, chicken classics,
                            tandoori plates, biryani, chaat, and more without
                            hunting through a crowded list.
                        </p>
                        <div class="menu-stats">
                            <div class="menu-stat">
                                <strong>{{ totalCounts.total }}</strong> Total
                                Dishes
                            </div>
                            <div class="menu-stat veg">
                                🟢 <strong>{{ totalCounts.veg }}</strong>
                                Vegetarian
                            </div>
                            <div class="menu-stat nonveg">
                                🔴 <strong>{{ totalCounts.nonveg }}</strong>
                                Non-Veg
                            </div>
                            <div class="menu-stat">
                                <strong>{{ cats.length }}</strong> Categories
                            </div>
                        </div>
                        <div class="menu-hero-panel">
                            <div class="menu-hero-panel-head">
                                <strong>Quick picks</strong>
                                <span>Tap a section to jump straight in</span>
                            </div>
                            <div class="menu-quick-jumps">
                                <button
                                    v-for="jump in quickJumps"
                                    :key="jump.label"
                                    type="button"
                                    class="menu-quick-jump"
                                    @click="jumpTo(jump.target)"
                                >
                                    <span>{{ jump.emoji }}</span>
                                    {{ jump.label }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="menu-hero-visual">
                        <button
                            type="button"
                            class="menu-spotlight"
                            @click="jumpTo(heroSpotlight.target)"
                        >
                            <img
                                :src="heroSpotlight.image"
                                :alt="heroSpotlight.name"
                                loading="lazy"
                                decoding="async"
                            />
                            <div class="menu-spotlight-content">
                                <div class="menu-spotlight-top">
                                    <span class="badge badge-veg"
                                        >Best Seller</span
                                    >
                                    <span class="menu-spotlight-kicker"
                                        >Most ordered pick</span
                                    >
                                </div>
                                <div class="menu-spotlight-body">
                                    <h2>{{ heroSpotlight.name }}</h2>
                                    <p>{{ heroSpotlight.note }}</p>
                                </div>
                                <div class="menu-spotlight-foot">
                                    <strong>{{ heroSpotlight.price }}</strong>
                                    <span>Jump to dish →</span>
                                </div>
                            </div>
                        </button>
                        <div class="menu-mini-gallery">
                            <button
                                v-for="(dish, index) in heroGallery"
                                :key="dish.name"
                                type="button"
                                class="menu-mini-card"
                                @click="jumpTo(dish.target)"
                            >
                                <img
                                    :src="dish.image"
                                    :alt="dish.name"
                                    loading="lazy"
                                    decoding="async"
                                />
                                <div class="menu-mini-card-copy">
                                    <div class="menu-mini-card-top">
                                        <span>{{ dish.eyebrow }}</span>
                                        <strong>{{ `0${index + 1}` }}</strong>
                                    </div>
                                    <h3>{{ dish.name }}</h3>
                                    <p>{{ dish.note }}</p>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- HOW WE COOK -->
        <section class="process-section">
            <div class="process-inner">
                <div class="process-head">
                    <div class="section-label">How We Cook</div>
                    <h2>Kitchen Process</h2>
                    <p>Simple, fresh, hot. No shortcuts.</p>
                </div>
                <div class="process-grid">
                    <div
                        v-for="step in processSteps"
                        :key="step.num"
                        class="process-step"
                    >
                        <span class="process-num">{{ step.num }}</span>
                        <span class="process-emoji">{{ step.emoji }}</span>
                        <h4>{{ step.title }}</h4>
                        <p>{{ step.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- MOBILE CATEGORY PILLS (visible on mobile only) -->
        <div class="mobile-cat-bar">
            <div class="mobile-cat-inner">
                <button
                    v-for="cat in cats"
                    :key="cat.id"
                    class="mobile-cat-pill"
                    :class="{ active: activeCat === cat.id }"
                    :data-target="cat.id"
                    @click="scrollTo(cat.id, $event)"
                >
                    {{ cat.icon }} {{ cat.title }}
                </button>
            </div>
        </div>

        <div class="menu-body">
            <aside class="menu-sidebar">
                <template v-for="group in sidebar" :key="group.heading">
                    <h3>{{ group.heading }}</h3>
                    <a
                        v-for="id in group.links"
                        :key="id"
                        class="sidebar-link"
                        :class="{ active: activeCat === id }"
                        :href="`#${id}`"
                        @click="scrollTo(id, $event)"
                    >
                        {{ sidebarLabels[id] }}
                        <span v-if="sidebarCounts[id]" class="count">{{
                            sidebarCounts[id]
                        }}</span>
                    </a>
                </template>
            </aside>

            <main>
                <!-- QUICK FILTER TOOLBAR -->
                <div class="menu-toolbar">
                    <div class="menu-search">
                        <span class="menu-search-icon">🔍</span>
                        <input
                            v-model="search"
                            type="search"
                            placeholder="Search menu..."
                            aria-label="Search menu"
                        />
                    </div>
                    <div class="filter-chips">
                        <button
                            class="filter-chip"
                            :class="{ active: filterType === 'all' }"
                            @click="filterType = 'all'"
                        >
                            All
                        </button>
                        <button
                            class="filter-chip veg"
                            :class="{ active: filterType === 'veg' }"
                            @click="filterType = 'veg'"
                        >
                            🟢 Veg
                        </button>
                        <button
                            class="filter-chip nonveg"
                            :class="{ active: filterType === 'nonveg' }"
                            @click="filterType = 'nonveg'"
                        >
                            🔴 Non-Veg
                        </button>
                    </div>
                    <div class="menu-toolbar-meta">
                        <span>{{ visibleItemCount }} dishes showing</span>
                        <button
                            v-if="hasActiveFilters"
                            type="button"
                            class="menu-toolbar-clear"
                            @click="clearFilters"
                        >
                            Clear filters
                        </button>
                    </div>
                </div>

                <div v-if="noResults" class="menu-empty">
                    <span class="icon">🔎</span>
                    <h3>No dishes found</h3>
                    <p>Try a different search term or clear the filters.</p>
                </div>

                <div
                    v-for="cat in filteredCats"
                    :key="cat.id"
                    class="menu-cat"
                    :id="cat.id"
                >
                    <div class="cat-head">
                        <div class="cat-icon">{{ cat.icon }}</div>
                        <div>
                            <h2>
                                {{ cat.title }}
                                <span
                                    v-if="cat.badge"
                                    class="badge"
                                    :class="
                                        cat.badge.type === 'veg'
                                            ? 'badge-veg'
                                            : 'badge-nonveg'
                                    "
                                    style="vertical-align: middle"
                                    >{{ cat.badge.label }}</span
                                >
                            </h2>
                            <div v-if="cat.note" class="cat-note">
                                {{ cat.note }}
                            </div>
                        </div>
                    </div>
                    <div class="items-grid">
                        <div
                            v-for="item in cat.items"
                            :key="item.name"
                            class="item-row"
                        >
                            <img
                                v-if="item.image"
                                :src="item.image"
                                :alt="item.name"
                                class="item-thumb"
                                loading="lazy"
                                decoding="async"
                            />
                            <div v-else class="item-thumb-ph">
                                {{ item.emoji }}
                            </div>
                            <div class="item-body">
                                <div class="item-meta">
                                    <span
                                        class="badge"
                                        :class="
                                            item.type === 'veg'
                                                ? 'badge-veg'
                                                : 'badge-nonveg'
                                        "
                                        >{{
                                            item.type === 'veg'
                                                ? 'Veg'
                                                : 'Non-Veg'
                                        }}</span
                                    >
                                    <span
                                        v-if="item.badge"
                                        class="badge badge-bestseller"
                                        >{{ item.badge }}</span
                                    >
                                    <span
                                        v-if="item.spice && item.spice > 0"
                                        class="spice-level"
                                    >
                                        <span v-for="n in item.spice" :key="n"
                                            >🌶️</span
                                        >
                                    </span>
                                </div>
                                <div class="item-name">{{ item.name }}</div>
                                <div v-if="item.desc" class="item-desc">
                                    {{ item.desc }}
                                </div>
                                <a
                                    :href="waOrder(item.name)"
                                    target="_blank"
                                    class="item-order"
                                    rel="noopener"
                                    >💬 Order on WhatsApp →</a
                                >
                            </div>
                            <div v-if="item.sizes" class="size-prices">
                                <span>{{ item.sizes.reg }}</span
                                >Reg<span>{{ item.sizes.large }}</span
                                >Large
                            </div>
                            <div v-else-if="item.perPiece" class="item-price">
                                <span>{{ item.price }}</span>
                                <small>per piece</small>
                            </div>
                            <div v-else class="item-price">
                                {{ item.price }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- BACK TO TOP -->
        <button
            class="back-to-top"
            :class="{ visible: showBackToTop }"
            aria-label="Back to top"
            @click="scrollTop"
        >
            ↑
        </button>

        <!-- FLOATING ACTION STACK -->
        <div class="fab-stack" :class="{ expanded: fabOpen }">
            <div class="fab-actions">
                <a
                    href="https://wa.me/16474471046"
                    target="_blank"
                    class="fab-item"
                    @click="fabOpen = false"
                >
                    <span class="fab-label">WhatsApp Order</span>
                    <span class="fab whatsapp">💬</span>
                </a>
                <a
                    href="tel:15193053663"
                    class="fab-item"
                    @click="fabOpen = false"
                >
                    <span class="fab-label">Call Us</span>
                    <span class="fab call">📞</span>
                </a>
                <a
                    href="https://www.skipthedishes.com/indian-grocery-and-takeout-ontario-st"
                    target="_blank"
                    class="fab-item"
                    @click="fabOpen = false"
                >
                    <span class="fab-label">Skip the Dishes</span>
                    <span class="fab order">🛵</span>
                </a>
            </div>
            <button
                class="fab main"
                :aria-label="fabOpen ? 'Close actions' : 'Open actions'"
                @click="fabOpen = !fabOpen"
            >
                +
            </button>
        </div>
    </AigstLayout>
</template>
