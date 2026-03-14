<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue, } from '@/components/ui/select';

const props = defineProps<{ event?: any }>();
const emit = defineEmits(['success']);

const form = useForm({
    name: props.event?.name ?? '',
    type: props.event?.type ?? '',
    category: props.event?.category ?? '',
});

const submit = () => {
    if (props.event) {
        form.put(route('events.update', props.event.id), {
            onSuccess: () => emit('success'),
        });
    } else {
        form.post(route('events.store'), {
            onSuccess: () => {
                form.reset();
                emit('success');
            },
        });
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4 w-full pt-4">
        <div class="grid gap-2">
            <Label for="name">Name</Label>
            <Input id="name" v-model="form.name" type="text" placeholder="Badketball" />
            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
        </div>

        <Select v-model="form.type">
            <SelectTrigger class="w-full">
                <SelectValue placeholder="Select a type from events" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem value="Single">Single</SelectItem>
                <SelectItem value="Team">Team</SelectItem>
            </SelectContent>
            <p v-if="form.errors.type" class="text-xs text-red-500">{{ form.errors.type }}</p>
        </Select>

        <div class="grid gap-2">
            <Label for="category">Category</Label>
            <Input id="category" v-model="form.category" type="text" />
            <p v-if="form.errors.category" class="text-xs text-red-500">{{ form.errors.category }}</p>
        </div>

        <Button type="submit" :disabled="form.processing" class="w-full mt-2">
            {{ form.processing ? 'Saving...' : (event ? 'Update Event' : 'Save Event') }}
        </Button>
    </form>
</template>