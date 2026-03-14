<script setup lang="ts">
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const props = defineProps<{ event?: any }>();
const emit = defineEmits(['success']);

const form = useForm({
    name:        props.event?.name ?? '',
    type:        props.event?.type ?? '',
    category:    props.event?.category ?? '',
    max_members: props.event?.max_members ?? '',
});

const isTeamEvent = computed(() => form.type === 'team');

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
    <form @submit.prevent="submit" class="space-y-4 pt-4">

        <div class="grid gap-2">
            <Label>Event Name</Label>
            <Input v-model="form.name" placeholder="e.g. 100m Relay" />
            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
        </div>

        <div class="grid gap-2">
            <Label>Type</Label>
            <Select v-model="form.type">
                <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select type" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="solo">Solo</SelectItem>
                    <SelectItem value="team">Team</SelectItem>
                </SelectContent>
            </Select>
            <p v-if="form.errors.type" class="text-xs text-red-500">{{ form.errors.type }}</p>
        </div>

        <div class="grid gap-2">
            <Label>Category</Label>
            <Select v-model="form.category">
                <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select category" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="male">Male</SelectItem>
                    <SelectItem value="female">Female</SelectItem>
                    <SelectItem value="mixed">Mixed</SelectItem>
                </SelectContent>
            </Select>
            <p v-if="form.errors.category" class="text-xs text-red-500">{{ form.errors.category }}</p>
        </div>

        <div v-if="isTeamEvent" class="grid gap-2">
            <Label>Max Athletes per Team</Label>
            <Input 
                v-model="form.max_members" 
                type="number" 
                min="2"
                placeholder="e.g. 5" 
            />
            <p class="text-xs text-muted-foreground">
                How many {{ form.category === 'male' ? 'male' : form.category === 'female' ? 'female' : '' }} 
                athletes can each team have in this event?
            </p>
            <p v-if="form.errors.max_members" class="text-xs text-red-500">{{ form.errors.max_members }}</p>
        </div>

        <Button type="submit" :disabled="form.processing" class="w-full mt-2">
            {{ form.processing ? 'Saving...' : (event ? 'Update Event' : 'Save Event') }}
        </Button>
    </form>
</template>