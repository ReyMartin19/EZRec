<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import AthleteForm from '@/components/AthleteForm.vue';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';

interface Athlete {
    id: number;
    name: string;
    age: number;
    team: { id: number; name: string } | null;
    coach: { id: number; name: string } | null;
    events: { id: number; name: string; type: string; category: string }[];
    team_id: number | null;
    coach_id: number | null;
}

defineProps<{
    athletes: Athlete[];
    eventList: { 
        id: number; 
        name: string;
        type: string;
        category: string;
    }[];
    teamList: { 
        id: number; 
        name: string;
    }[];
    coachList: { 
        id: number; 
        name: string;
    }[];
}>();

const selectedAthlete = ref<Athlete | null>(null);

const isModalOpen = ref(false);

const openEditModal = (athlete: Athlete) => {
    selectedAthlete.value = athlete;
    isModalOpen.value = true;
};

const openCreateModal = () => {
    selectedAthlete.value = null;
    isModalOpen.value = true;
};
</script>

<template>
    <AppLayout>
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Athletes Registry</h1>

                <Dialog v-model:open="isModalOpen">
                    <DialogTrigger as-child>
                        <Button @click="openCreateModal" class="gap-2">
                            <Plus class="h-4 w-4" /> Add Athlete
                        </Button>
                    </DialogTrigger>
                    
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>{{ selectedAthlete ? 'Edit Athlete' : 'Add New Athlete' }}</DialogTitle>
                        </DialogHeader>
                        <AthleteForm 
                            :key="selectedAthlete?.id || 'new'" 
                            :events="eventList"
                            :teams="teamList"
                            :coaches="coachList"
                            :athlete="selectedAthlete" 
                            @success="isModalOpen = false" 
                        />
                    </DialogContent>
                </Dialog>
            </div>

            <div class="rounded-md border bg-card">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted/50 border-b">
                        <tr>
                            <th class="p-4 font-medium">Name</th>
                            <th class="p-4 font-medium text-center">Age</th>
                            <th class="p-4 font-medium text-center">Team</th>
                            <th class="p-4 font-medium text-center">Event</th>
                            <th class="p-4 font-medium text-center">Coach</th>
                            <th class="p-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="athlete in athletes" :key="athlete.id" class="hover:bg-muted/40">
                            <td class="p-4 font-semibold">{{ athlete.name }}</td>
                            <td class="p-4 text-center">{{ athlete.age }}</td>
                            <td class="p-4 text-center">{{ athlete.team?.name ?? '—' }}</td>
                            <td class="p-4">
                                <div class="flex flex-col gap-0.8">
                                    <span
                                        v-for="event in athlete.events"
                                        :key="event.id"
                                        class="px-0.5 py-0.5 text-xs text-center"
                                    >
                                        {{ event.name }} - <span class="text-muted-foreground"> {{ event.type }}  {{ event.category }} </span>
                                    </span>
                                    <span v-if="!athlete.events?.length">—</span>
                                </div>
                            </td>
                            <td class="p-4 text-center">{{ athlete.coach?.name ?? '—' }}</td>
                            <td class="p-4 text-right">
                                <Button variant="ghost" size="sm" @click="openEditModal(athlete)">Edit</Button>
                            </td>
                        </tr>
                        <tr v-if="athletes.length === 0">
                            <td colspan="4" class="p-8 text-center text-muted-foreground">No athletes found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>