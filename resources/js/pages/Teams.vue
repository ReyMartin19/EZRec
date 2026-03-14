<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import TeamForm from '@/components/TeamForm.vue';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger, } from '@/components/ui/dialog';

interface Team {
    id: number;
    name: string;
}

defineProps<{
    teams: Team[];
}>();

const selectedTeam = ref<Team | null>(null);

const isModalOpen = ref(false);

const openEditModal = (team: Team) => {
    selectedTeam.value = team;
    isModalOpen.value = true;
};

const openCreateModal = () => {
    selectedTeam.value = null;
    isModalOpen.value = true;
};
</script>

<template>
    <AppLayout>
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Team Registry</h1>

                <Dialog v-model:open="isModalOpen">
                    <DialogTrigger as-child>
                        <Button @click="openCreateModal" class="gap-2">
                            <Plus class="h-4 w-4" /> Add Team
                        </Button>
                    </DialogTrigger>
                    
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>{{ selectedTeam ? 'Edit Team' : 'Add New Team' }}</DialogTitle>
                        </DialogHeader>
                        <TeamForm 
                            :key="selectedTeam?.id || 'new'" 
                            :team="selectedTeam" 
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
                            <th class="p-4 font-medium text-muted-foreground text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="team in teams" :key="team.id" class="hover:bg-muted/50 transition-colors">
                            <td class="p-4 font-semibold">{{ team.name }}</td>
                            <td class="p-4 text-right">
                                <Button variant="ghost" size="sm" @click="openEditModal(team)">Edit</Button>
                            </td>
                        </tr>

                        <tr v-if="teams.length === 0">
                            <td colspan="4" class="p-8 text-center text-muted-foreground">
                                No teams found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>