<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = defineProps<{ athlete?: any }>();
const emit = defineEmits(['success']);

const form = useForm({
    name: props.athlete?.name ?? '',
    sport: props.athlete?.sport ?? '',
    age: props.athlete?.age ?? '',
});

const submit = () => {
    if (props.athlete) {
        form.put(route('athletes.update', props.athlete.id), {
            onSuccess: () => emit('success'),
        });
    } else {
        form.post(route('athletes.store'), {
            onSuccess: () => {
                form.reset();
                emit('success');
            },
        });
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4 pt-4">
        <div class="grid gap-2">
            <Label for="name">Full Name</Label>
            <Input id="name" v-model="form.name" placeholder="Name" />
            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
        </div>

        <div class="grid gap-2">
            <Label for="age">Age</Label>
            <Input id="age" v-model="form.age" type="number" />
            <p v-if="form.errors.age" class="text-xs text-red-500">{{ form.errors.age }}</p>
        </div>

        <div class="grid gap-2">
            <Label for="sport">Sport</Label>
            <Input id="sport" v-model="form.sport" placeholder="e.g. Basketball" />
            <p v-if="form.errors.sport" class="text-xs text-red-500">{{ form.errors.sport }}</p>
        </div>

        <Button type="submit" :disabled="form.processing" class="w-full mt-2">
            {{ form.processing ? 'Saving...' : (athlete ? 'Update Athlete' : 'Save Athlete') }}
        </Button>
    </form>
</template>