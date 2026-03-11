<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import AthleteForm from '@/components/AthleteForm.vue';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next'; // Icon for the button
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

// 1. Define the props coming from Laravel
defineProps<{
    athletes: Array<{
        id: number;
        name: string;
        sport: string;
        age: number;
    }>;
}>();

// This controls if the popup is visible or not
const isModalOpen = ref(false);
</script>

<template>
    <AppLayout>
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Athletes Registry</h1>

                <Dialog v-model:open="isModalOpen">
                    <DialogTrigger as-child>
                        <Button class="gap-2">
                            <Plus class="h-4 w-4" />
                            Add Athlete
                        </Button>
                    </DialogTrigger>
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Add New Athlete</DialogTitle>
                        </DialogHeader>
                        <AthleteForm @success="isModalOpen = false" />
                    </DialogContent>
                </Dialog>
            </div>

            <div class="rounded-md border bg-card">
                <table class="w-full text-sm">
                    <thead class="bg-muted/50 border-b">
                        <tr class="text-left">
                            <th class="p-4 font-medium text-muted-foreground">Name</th>
                            <th class="p-4 font-medium text-muted-foreground">Sport</th>
                            <th class="p-4 font-medium text-muted-foreground text-center">Age</th>
                            <th class="p-4 font-medium text-muted-foreground text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="athlete in athletes" :key="athlete.id" class="hover:bg-muted/50 transition-colors">
                            <td class="p-4 font-semibold">{{ athlete.name }}</td>
                            <td class="p-4">{{ athlete.sport }}</td>
                            <td class="p-4 text-center">{{ athlete.age }}</td>
                            <td class="p-4 text-right">
                                <Button variant="ghost" size="sm">
                                    <a href="">Edit</a>
                                </Button>
                            </td>
                        </tr>

                        <tr v-if="athletes.length === 0">
                            <td colspan="4" class="p-8 text-center text-muted-foreground">
                                No athletes found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>