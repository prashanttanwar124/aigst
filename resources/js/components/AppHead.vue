<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface SeoSharedProps {
    baseUrl: string;
    defaultDescription: string;
    defaultImage: string;
    defaultTitle: string;
    locale: string;
    siteName: string;
}

interface StructuredData {
    [key: string]: unknown;
}

const props = withDefaults(
    defineProps<{
        title?: string;
        description?: string;
        path?: string;
        image?: string;
        type?: 'website' | 'article';
        noindex?: boolean;
        keywords?: string[];
        structuredData?: StructuredData | StructuredData[];
    }>(),
    {
        title: undefined,
        description: undefined,
        path: undefined,
        image: undefined,
        type: 'website',
        noindex: false,
        keywords: () => [],
        structuredData: undefined,
    },
);

const page = usePage();

const fallbackSeo: SeoSharedProps = {
    baseUrl: 'http://localhost',
    defaultDescription:
        'Indian Grocery & Takeout serves authentic North Indian food, catering, and party trays in Stratford, Ontario.',
    defaultImage: '/apple-touch-icon.png',
    defaultTitle: 'Indian Grocery & Takeout',
    locale: 'en_CA',
    siteName: 'Indian Grocery & Takeout',
};

const sharedSeo = computed(
    () => (page.props.seo ?? {}) as Partial<SeoSharedProps>,
);

const seo = computed(() => ({
    ...fallbackSeo,
    ...sharedSeo.value,
}));

const metaTitle = computed(() => props.title ?? seo.value.defaultTitle);
const metaDescription = computed(
    () => props.description ?? seo.value.defaultDescription,
);
const canonicalUrl = computed(() =>
    new URL(props.path ?? page.url ?? '/', seo.value.baseUrl).toString(),
);
const imageUrl = computed(() =>
    new URL(
        props.image ?? seo.value.defaultImage,
        seo.value.baseUrl,
    ).toString(),
);
const keywords = computed(() =>
    props.keywords.length > 0 ? props.keywords.join(', ') : null,
);
const structuredDataItems = computed(() => {
    if (!props.structuredData) {
        return [];
    }

    return Array.isArray(props.structuredData)
        ? props.structuredData
        : [props.structuredData];
});
</script>

<template>
    <Head :title="metaTitle">
        <meta
            head-key="description"
            name="description"
            :content="metaDescription"
        />
        <meta
            head-key="robots"
            name="robots"
            :content="
                noindex
                    ? 'noindex, nofollow'
                    : 'index, follow, max-image-preview:large'
            "
        />
        <meta
            v-if="keywords"
            head-key="keywords"
            name="keywords"
            :content="keywords"
        />

        <link head-key="canonical" rel="canonical" :href="canonicalUrl" />

        <meta head-key="og:type" property="og:type" :content="type" />
        <meta
            head-key="og:site_name"
            property="og:site_name"
            :content="seo.siteName"
        />
        <meta head-key="og:locale" property="og:locale" :content="seo.locale" />
        <meta head-key="og:title" property="og:title" :content="metaTitle" />
        <meta
            head-key="og:description"
            property="og:description"
            :content="metaDescription"
        />
        <meta head-key="og:url" property="og:url" :content="canonicalUrl" />
        <meta head-key="og:image" property="og:image" :content="imageUrl" />

        <meta
            head-key="twitter:card"
            name="twitter:card"
            content="summary_large_image"
        />
        <meta
            head-key="twitter:title"
            name="twitter:title"
            :content="metaTitle"
        />
        <meta
            head-key="twitter:description"
            name="twitter:description"
            :content="metaDescription"
        />
        <meta
            head-key="twitter:image"
            name="twitter:image"
            :content="imageUrl"
        />

        <component
            v-for="(item, index) in structuredDataItems"
            :key="`structured-data-${index}`"
            :is="'script'"
            :head-key="`structured-data-${index}`"
            type="application/ld+json"
            v-text="JSON.stringify(item)"
        >
        </component>
    </Head>
</template>
