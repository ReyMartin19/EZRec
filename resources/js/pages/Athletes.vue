<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import AthleteForm from '@/components/AthleteForm.vue'; // Import your component

const showForm = ref(false); // The "Toggle" state
</script>

<template>
    <AppLayout>
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex justify-start">
                <button @click="showForm = !showForm" class="btn-primary inline-flex items-center gap-2">
                    <Plus class="h-4 w-4" />
                    Add Athlete
                </button>
            </div>

            <div v-if="showForm" class="mt-8 pt-8 border-t flex justify-center w-full">
                <div class="w-full max-w-lg">
                    <AthleteForm @success="showForm = false" />
                </div>
            </div>
            
            <div v-else class="mt-8">
                <!-- Data display will go here -->
            </div>
        </div>
    </AppLayout>
</template>