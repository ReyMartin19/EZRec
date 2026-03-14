<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = defineProps<{ team?: any }>();
const emit = defineEmits(['success']);

const form = useForm({
    name: props.team?.name ?? '',
});

const submit = () => {
    if (props.team) {
        form.put(route('teams.update', props.team.id), {
            onSuccess: () => emit('success'),
        });
    } else {
        form.post(route('teams.store'), {
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
            <Input id="name" v-model="form.name" type="text" placeholder="Ananido" />
            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
        </div>

        <Button type="submit" :disabled="form.processing" class="w-full mt-2">
            {{ form.processing ? 'Saving...' : (team ? 'Update Team' : 'Save Team') }}
        </Button>
    </form>
</template>