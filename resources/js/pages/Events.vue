<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import EventForm from '@/components/EventForm.vue';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next'; // Icon for the button
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger, } from '@/components/ui/dialog';

interface Event {
    id: number;
    name: string;
    type: string;
    category: string;
}

defineProps<{
    events: Event[];
}>();

const selectedEvent = ref<Event | null>(null);

const isModalOpen = ref(false);

const openEditModal = (event: Event) => {
    selectedEvent.value = event;
    isModalOpen.value = true;
};

const openCreateModal = () => {
    selectedEvent.value = null;
    isModalOpen.value = true;
};
</script>

<template>
    <AppLayout>
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Events Registry</h1>

                <Dialog v-model:open="isModalOpen">
                    <DialogTrigger as-child>
                        <Button @click="openCreateModal" class="gap-2">
                            <Plus class="h-4 w-4" /> Add Athlete
                        </Button>
                    </DialogTrigger>
                    
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>{{ selectedEvent ? 'Edit Event' : 'Add New Event' }}</DialogTitle>
                        </DialogHeader>
                        <EventForm 
                            :key="selectedEvent?.id || 'new'" 
                            :event="selectedEvent" 
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
                            <th class="p-4 font-medium text-muted-foreground">Type</th>
                            <th class="p-4 font-medium text-muted-foreground text-center">Category</th>
                            <th class="p-4 font-medium text-muted-foreground text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="event in events" :key="event.id" class="hover:bg-muted/50 transition-colors">
                            <td class="p-4 font-semibold">{{ event.name }}</td>
                            <td class="p-4">{{ event.type }}</td>
                            <td class="p-4 text-center">{{ event.category }}</td>
                            <td class="p-4 text-right">
                                <Button variant="ghost" size="sm" @click="openEditModal(event)">Edit</Button>
                            </td>
                        </tr>

                        <tr v-if="events.length === 0">
                            <td colspan="4" class="p-8 text-center text-muted-foreground">
                                No events found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>