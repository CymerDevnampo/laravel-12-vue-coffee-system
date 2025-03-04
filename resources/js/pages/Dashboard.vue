<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Button from '../components/ui/button/Button.vue';
import { Label } from '@/components/ui/label';
import Swal from 'sweetalert2';

// Define proper type for coffee objects
interface Coffee {
    id: number;
    coffee_name: string;
    image: string;
    quantity: number;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps<{
    coffees: Coffee[];
}>();

const buyNow = (coffeeId: number) => {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: 'Processing...',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });

    const form = useForm({
        coffee_id: coffeeId,
    });

    form.post(route('store.order'), {
        onFinish: () => form.reset(),
        onSuccess: () => {
            Swal.close();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Coffee ordered successfully!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        },
        onError: () => {
            Swal.close();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Something went wrong. Please try again!',
                showConfirmButton: false,
                timer: 2000,
            });
        },
    });
}
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div v-for="coffee in coffees" :key="coffee.id"
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <Label class="absolute bottom-2 left-1/2 -translate-x-1/2">{{ coffee.coffee_name }}</Label>
                    <img :src="`/storage/coffees/images/${coffee.image}`" class="h-full w-full object-cover"
                        :alt="coffee.coffee_name" />
                    <Button class="absolute bottom-6 left-1/2 -translate-x-1/2" @click="buyNow(coffee.id)">Buy
                        Now</Button>
                </div>
            </div>

            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
