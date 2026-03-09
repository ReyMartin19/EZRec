<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const form = useForm({
    name: '',
    sport: '',
    age: '',
});

const submit = () => {
    form.post(route('athletes.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div class="">
        <h1 class="mb-4 text-xl font-bold text-center">Add New Athlete</h1>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <Label for="name">Full Name</Label>
                <Input id="name" v-model="form.name" type="text" />
                <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
            </div>

            <div>
                <Label for="age">Age</Label>
                <Input id="age" v-model="form.age" type="number" />
                <div v-if="form.errors.age" class="text-sm text-red-500">{{ form.errors.age }}</div>
            </div>

            <div>
                <Label for="sport">Sport</Label>
                <Input id="sport" v-model="form.sport" type="text" />
                <div v-if="form.errors.sport" class="text-sm text-red-500">{{ form.errors.sport }}</div>
            </div>

            <Button type="submit" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Save Athlete' }}
            </Button>
        </form>
    </div>
</template>