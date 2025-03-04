<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import Button from '../../components/ui/button/Button.vue';
import InputError from '@/components/InputError.vue';
import { LoaderCircle } from 'lucide-vue-next';
import Swal from 'sweetalert2';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create an coffee',
        href: '/create/coffee',
    },
];

const form = useForm({
    image: null as File | null, // Change from string to File | null
    coffee_name: '',
    quantity: '',
});

const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files) {
        form.image = target.files[0];
    }
};

const submit = () => {
    // Show the "Processing..." toast immediately
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: 'Processing...',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });

    const formData = new FormData();

    // Only append image if it's not null
    if (form.image) {
        formData.append('image', form.image);
    }

    formData.append('coffee_name', form.coffee_name);
    formData.append('quantity', form.quantity);

    form.post(route('store.coffee'), {
        onFinish: () => form.reset(),
        onSuccess: () => {
            // Close any existing toasts and show success
            Swal.close();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Coffee created successfully!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
                // .then(() => {
                //     window.location.href = route('dashboard');
                // });
        },
        onError: () => {
            // Close any existing toasts and show error
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
};
</script>

<template>

    <Head title="Create Coffee" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid grid-cols-3 gap-4">

                    <div class="grid gap-2">
                        <Label for="image">Image</Label>
                        <Input id="image" type="file" required autofocus :tabindex="1" @input="handleFileUpload"
                            placeholder="" accept="image/*" />
                        <InputError :message="form.errors.image" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="coffee_name">Coffee Name</Label>
                        <Input id="coffee_name" type="text" required :tabindex="2" autocomplete="coffee_name"
                            v-model="form.coffee_name" placeholder="" />
                        <InputError :message="form.errors.coffee_name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="quantity">Quantity</Label>
                        <Input id="quantity" type="number" required :tabindex="3" autocomplete="quantity"
                            v-model="form.quantity" placeholder="" />
                        <InputError :message="form.errors.quantity" />
                    </div>

                    <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Submit
                    </Button>
                </div>
            </form>


        </div>

    </AppLayout>


</template>
