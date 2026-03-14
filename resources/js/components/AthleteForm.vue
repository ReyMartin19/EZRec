<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
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

// ✅ Filter out team events that are full for the selected team
const availableEvents = computed(() => {
    return props.events.filter(event => {
        // Solo events are always available
        if (event.type === 'solo') return true;

        // Team events — check if selected team is full
        if (event.type === 'team' && event.max_members && form.team_id) {
            const teamCount = event.team_counts?.[form.team_id] ?? 0;
            const isEditingCurrent = props.athlete && String(props.athlete.team_id) === String(form.team_id) && props.athlete.events?.some((e: any) => String(e.id) === String(event.id));
            if (isEditingCurrent) return true;
            return teamCount < event.max_members;
        }

        return true;
    });
});

// ✅ Filter out teams that are full for any of the selected events
const availableTeams = computed(() => {
    return props.teams.filter(team => {
        if (!form.event_ids.length) return true;

        const teamStr = String(team.id);
        for (const eventId of form.event_ids) {
            const event = props.events.find(e => String(e.id) === eventId);
            if (event && event.type === 'team' && event.max_members) {
                const teamCount = event.team_counts?.[teamStr] ?? 0;
                const isEditingCurrent = props.athlete && String(props.athlete.team_id) === teamStr && props.athlete.events?.some((e: any) => String(e.id) === String(event.id));
                
                if (!isEditingCurrent && teamCount >= event.max_members) {
                    return false;
                }
            }
        }
        return true;
    });
});

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

        <!-- ✅ Only shows events not full for the selected team -->
        <div class="grid gap-2">
            <Label>Events</Label>
            <p class="text-xs text-muted-foreground">
                Team events that are full will not appear.
            </p>
            <div 
                v-for="event in availableEvents" 
                :key="event.id" 
                class="flex items-center gap-2"
            >
                <input 
                    type="checkbox" 
                    :value="String(event.id)"
                    v-model="form.event_ids"
                />
                <span class="text-sm">
                    {{ event.name }} — {{ event.type }} — {{ event.category }}
                    <span v-if="event.type === 'team'" class="text-xs text-muted-foreground">
                        ({{ event.team_counts?.[form.team_id] ?? 0 }}/{{ event.max_members }} athletes)
                    </span>
                </span>
            </div>

            <p v-if="!availableEvents.length" class="text-xs text-muted-foreground">
                No available events for this team.
            </p>
            <p v-if="form.errors.event_ids" class="text-xs text-red-500">
                {{ form.errors.event_ids }}
            </p>
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
                    v-for="team in availableTeams" 
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