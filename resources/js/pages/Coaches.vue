<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { coaches } from '@/routes';

const breadcrumbs = [
    {
        title: 'Coaches',
        href: coaches(),
    },
];
</script>

<template>
    <Head title="Coaches" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="m-4">Coaches</h1>
    </AppLayout>
</template>
