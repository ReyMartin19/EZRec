<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { events } from '@/routes';

const breadcrumbs = [
    {
        title: 'Events',
        href: events(),
    },
];
</script>

<template>
    <Head title="Events" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="m-4">Events</h1>
    </AppLayout>
</template>
