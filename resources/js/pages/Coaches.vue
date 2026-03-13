<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import CoachForm from '@/components/CoachForm.vue';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger, } from '@/components/ui/dialog';

interface Coach {
    id: number;
    name: string;
    event: string;
    gender: string;
}

defineProps<{
    coaches: Coach[];
    eventList: { id: number; name: string }[];

}>();

const selectedCoach = ref<Coach | null>(null);

const isModalOpen = ref(false);

const openEditModal = (coach: Coach) => {
    selectedCoach.value = coach;
    isModalOpen.value = true;
};

const openCreateModal = () => {
    selectedCoach.value = null;
    isModalOpen.value = true;
};
</script>

<template>
    <AppLayout>
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Coaches Registry</h1>

                <Dialog v-model:open="isModalOpen">
                    <DialogTrigger as-child>
                        <Button @click="openCreateModal" class="gap-2">
                            <Plus class="h-4 w-4" /> Add Coach
                        </Button>
                    </DialogTrigger>
                    
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>{{ selectedCoach ? 'Edit Coach' : 'Add New Coach' }}</DialogTitle>
                        </DialogHeader>
                        <CoachForm 
                            :key="selectedCoach?.id || 'new'" 
                            :events="eventList"
                            :coach="selectedCoach" 
                            @success="isModalOpen = false" 
                        />
                    </DialogContent>
                </Dialog>
            </div>

            <div class="rounded-md border bg-card">
                <table class="w-full text-sm">
                    <thead class="bg-muted/50 border-b">
                        <tr class="text-left">
                            <th class="p-4 font-medium text-muted-foreground">Name</th>
                            <th class="p-4 font-medium text-muted-foreground">Event</th>
                            <th class="p-4 font-medium text-muted-foreground text-center">Gender</th>
                            <th class="p-4 font-medium text-muted-foreground text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="coach in coaches" :key="coach.id" class="hover:bg-muted/50 transition-colors">
                            <td class="p-4 font-semibold">{{ coach.name }}</td>
                            <td class="p-4">{{ coach.event }}</td>
                            <td class="p-4 text-center">{{ coach.gender }}</td>
                            <td class="p-4 text-right">
                                <Button variant="ghost" size="sm" @click="openEditModal(coach)">Edit</Button>
                            </td>
                        </tr>

                        <tr v-if="coaches.length === 0">
                            <td colspan="4" class="p-8 text-center text-muted-foreground">
                                No coaches found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>