<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

// 1. Tell the component it is allowed to send a "success" signal
const emit = defineEmits(['success']);

const form = useForm({
    name: '',
    type: '',
    category: '',
});

const submit = () => {
    // Replace 'route' with your specific helper if needed
    form.post(route('events.store'), {
        onSuccess: () => {
            form.reset();
            // 2. Shout to the parent: "I successfully saved! You can close now!"
            emit('success');
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4 w-full pt-4">
        <div class="grid gap-2">
            <Label for="name">Name</Label>
            <Input id="name" v-model="form.name" type="text" placeholder="Badketball" />
            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
        </div>

        <div class="grid gap-2">
            <Label for="type">Type</Label>
            <Input id="type" v-model="form.type" type="text" />
            <p v-if="form.errors.type" class="text-xs text-red-500">{{ form.errors.type }}</p>
        </div>

        <div class="grid gap-2">
            <Label for="category">Category</Label>
            <Input id="category" v-model="form.category" type="text" />
            <p v-if="form.errors.category" class="text-xs text-red-500">{{ form.errors.category }}</p>
        </div>

        <Button type="submit" :disabled="form.processing" class="w-full mt-2">
            {{ form.processing ? 'Saving...' : 'Save Event' }}
        </Button>
    </form>
</template>