<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue, } from '@/components/ui/select';

const props = defineProps<{ athlete?: any; events: any[]; teams: any[]; coaches: any[]; }>();
const emit = defineEmits(['success']);

const form = useForm({
    name: props.athlete?.name ?? '',
    age: props.athlete?.age ?? '',
    coach_id: props.athlete?.coach_id ?? '',
    team_id: props.athlete?.team_id ?? '',
    event_ids: props.athlete?.events?.map((e: any) => String(e.id)) ?? [],
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
            <Label>Events</Label>
            <div v-for="event in events" :key="event.id" class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    :value="String(event.id)"
                    v-model="form.event_ids"
                />
                <span>{{ event.name }} - {{ event.type }} - {{ event.category }}</span>
            </div>
        </div>
        
        <Select v-model="form.coach_id">
            <SelectTrigger class="w-full">
                <SelectValue placeholder="Select a coach" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem 
                    v-for="coach in coaches" 
                    :key="coach.id" 
                    :value="String(coach.id)"
                >
                    {{ coach.name }}
                </SelectItem>
            </SelectContent>
            <p v-if="form.errors.coach_id" class="text-xs text-red-500">{{ form.errors.coach_id }}</p>
        </Select>

        <Select v-model="form.team_id">
            <SelectTrigger class="w-full">
                <SelectValue placeholder="Select a team" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem 
                    v-for="team in teams" 
                    :key="team.id" 
                   :value="String(team.id)"
                >
                    {{ team.name }}
                </SelectItem>
            </SelectContent>
            <p v-if="form.errors.team_id" class="text-xs text-red-500">{{ form.errors.team_id }}</p>
        </Select>

        <Button type="submit" :disabled="form.processing" class="w-full mt-2">
            {{ form.processing ? 'Saving...' : (athlete ? 'Update Athlete' : 'Save Athlete') }}
        </Button>
    </form>
</template>