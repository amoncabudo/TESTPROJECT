<template>
    <!-- Define el título de la página -->
    <Head title="Crear Comida" />
       
    <!-- Contenedor principal -->
    <div class="container mx-auto p-4">
        <!-- Título de la página -->
        <h1 class="text-xl font-bold mb-4">Crear comida</h1>
        
        <!-- Formulario en un contenedor con borde -->
        <div class="bg-white p-4 border rounded">
            <!-- Formulario con método para prevenir el envío normal -->
            <form @submit.prevent="submit">
                <!-- Campo para el name del comida -->
                <div class="mb-3">
                    <!-- Etiqueta del campo -->
                    <label for="name" class="block mb-1">name:</label>
                    <!-- Input para el name -->
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="w-full border p-2 rounded"
                        required
                    />
                    <!-- Mensaje de error si existe -->
                    <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
                </div>

                <!-- Campo para la descripción -->
                <div class="mb-3">
                    <label for="description" class="block mb-1">Description:</label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="3"
                        class="w-full border p-2 rounded"
                    ></textarea>
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


                <!-- Botones de acción -->
                <div class="flex justify-between mt-4">
                    <!-- Botón para cancelar y volver al listado -->
                    <Link :href="route('comida.index')" class="bg-gray-300 px-3 py-1 rounded">
                        Cancelar
                    </Link>
                    <!-- Botón para guardar el formulario -->
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',     
    description: '',
    image: '', 
});

function submit() {
    form.post(route('comida.store'));
}
</script> 