<template>
    <Head title="Editar comida" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Editar comida</h1>
        
        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    />
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    ></textarea>
                    <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
                </div>

                <div class="mb-3">
                    <label for="image" class="block mb-1">Imagen:</label>
                    <input
                        type="file"
                        id="image"
                        @input="form.image = $event.target.files[0]"
                        class="w-full border p-2 rounded"
                        accept="image/*"
                    />
                    <div v-if="form.errors.image" class="text-red-500 text-sm">{{ form.errors.image }}</div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <Link
                        :href="route('comida.index')"
                        class="px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Cancelar
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

// Define props
const props = defineProps({
    comida: Object,
});

// Create form with initial values from props
const form = useForm({
    name: props.comida.name,
    description: props.comida.description,
    image: null, // Set to null initially since we'll only update if a new file is selected
    _method: 'PUT', // Add this to ensure Laravel recognizes it as a PUT request
});

// Submit function
function submit() {
    // Set multipart/form-data encoding type for file uploads
    form.post(route('comida.update', props.comida.id), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            // Reset the form after successful submission
            form.reset('image');
        },
    });
}
</script> 