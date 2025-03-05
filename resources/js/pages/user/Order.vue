<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import Button from '../../components/ui/button/Button.vue';
import { Label } from '@/components/ui/label';
import Swal from 'sweetalert2';
import Input from '../../components/ui/input/Input.vue';


// Define proper type for coffee objects
interface Order {
    id: number;
    coffee_name: string;
    image: string;
    quantity: number;
    coffee: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps<{
    orders: Order[];
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
            <div class="flex flex-wrap gap-4"> <!-- Added flex and wrap to ensure items are responsive -->

                <div v-for="data in orders" :key="data.id">
                    <a href="#"
                        class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">

                        <img class="object-cover w-full md:w-48" :src="`/storage/coffees/images/${data.coffee.image}`">
                        <div class="flex flex-col justify-between p-4 leading-normal">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{
                                data.coffee.coffee_name }}</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise
                                technology acquisitions of 2021 so far, in reverse chronological order.</p>
                            <!-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ data.coffee.quantity }}</p> -->
                            <!-- <Input type="number"> </Input> -->
                        </div>
                    </a>
                </div>
            </div>

            <!-- <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div> -->
        </div>
    </AppLayout>
</template>
