<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { teams } from '@/routes';

const breadcrumbs = [
    {
        title: 'Teams',
        href: teams(),
    },
];
</script>

<template>
    <Head title="Teams" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="m-4">Teams</h1>
    </AppLayout>
</template>
