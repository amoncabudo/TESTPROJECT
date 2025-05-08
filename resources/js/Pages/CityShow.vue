<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-6">
            <h1 class="text-xl font-medium text-gray-800 text-center">
                Detalles de {{ cities.name }}
            </h1>
        </div>
        
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Región</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ cities.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ cities.description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ cities.region ? cities.region.name : 'Sin Región' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img class="h-16 w-16 object-cover rounded" :src="`/storage/${cities.image}`" :alt="cities.name">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="mt-8 flex justify-center">
            <Link :href="route('city.index')" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-md text-sm transition-colors mr-3">
                Volver a la lista
            </Link>
            <Link :href="route('city.edit', cities.id)" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm transition-colors">
                Editar ciudad
            </Link>
        </div>
        
        <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
            <div class="relative">
                <img 
                    :src="`/storage/${cities.image}`" 
                    :alt="cities.name"
                    class="w-full h-64 object-cover"
                />
                <div class="absolute bottom-0 w-full bg-gradient-to-t from-black/70 to-transparent text-white p-4">
                    <div class="text-center text-lg font-medium">
                        {{ cities.name }} - {{ cities.region ? cities.region.name : 'Sin Región' }}
                    </div>
                    <div class="text-center text-sm mt-1 opacity-90">
                        {{ cities.description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    cities: Object,
});
</script>