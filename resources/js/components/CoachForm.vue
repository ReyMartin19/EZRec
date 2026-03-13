<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue, } from '@/components/ui/select';

const props = defineProps<{ coach?: any; events: any[]; }>();
const emit = defineEmits(['success']);

const form = useForm({
    name: props.coach?.name ?? '',
    event: props.coach?.event ?? '',
    gender: props.coach?.gender ?? '',
});

const submit = () => {
    if (props.coach) {
        form.put(route('coaches.update', props.coach.id), {
            onSuccess: () => emit('success'),
        });
    } else {
        form.post(route('coaches.store'), {
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
            <Input id="name" v-model="form.name" type="text" placeholder="Ernesto" />
            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
        </div>

        <Select v-model="form.event">
            <SelectTrigger class="w-full">
                <SelectValue placeholder="Select a sport from events" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem 
                    v-for="event in events" 
                    :key="event.id" 
                    :value="event.name"
                >
                    {{ event.name }}
                </SelectItem>
            </SelectContent>
            <p v-if="form.errors.event" class="text-xs text-red-500">{{ form.errors.event }}</p>
        </Select>

        <div class="grid gap-2">
            <Label for="gender">Gender</Label>
            <Input id="gender" v-model="form.gender" type="text" />
            <p v-if="form.errors.gender" class="text-xs text-red-500">{{ form.errors.gender }}</p>
        </div>

        <Button type="submit" :disabled="form.processing" class="w-full mt-2">
            {{ form.processing ? 'Saving...' : (coach ? 'Update Coach' : 'Save Coach') }}
        </Button>
    </form>
</template>