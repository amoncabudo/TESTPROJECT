<template>
    <Navbar />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-medium text-gray-800">Lista de Ciudades</h1>
            <button @click="CreateCity"
                class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md text-sm transition-colors">
                Crear Ciudad
            </button>
        </div>

        <div class="mb-6 flex items-center space-x-4">
            <input
                type="text"
                v-model="search"
                placeholder="Buscar por nombre o región"
                class="flex-grow text-base px-6 py-3 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                aria-label="Buscador"
            />

            <label for="regionSelect" class="sr-only">Filtrar por región</label>
            <select
                id="regionSelect"
                v-model="selectedRegion"
                class="w-48 px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
            >
                <option value="">Todas las regiones</option>
                <option v-for="region in uniqueRegions" :key="region" :value="region">
                    {{ region }}
                </option>
            </select>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Región</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Imagen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="city in filteredCities" :key="city.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ city.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ city.description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ city.region ? city.region.name : 'Sin Región' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img class="h-16 w-16 object-cover rounded" :src="`/storage/${city.image}`"
                                :alt="city.name">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-3">
                                <Link :href="route('city.show', city.id)" class="text-green-800 hover:text-indigo-900">
                                    Ver</Link>
                                <Link :href="route('city.edit', city.id)" class="text-blue-600 hover:text-blue-900">
                                    Editar</Link>
                                <button @click="DeleteCity(city.id)"
                                    class="text-red-600 hover:text-red-900">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';

const props = defineProps({
    cities: Array
});

const search = ref('');
const selectedRegion = ref('');
const uniqueRegions = computed(() => {
    const regions = props.cities.map(city => city.region ? city.region.name : 'Sin Región');
    return [...new Set(regions)];
});

const filteredCities = computed(() =>
    props.cities.filter(city => {
        const matchesSearch = city.name.toLowerCase().includes(search.value.toLowerCase()) ||
            (city.region && city.region.name.toLowerCase().includes(search.value.toLowerCase()));
        const matchesRegion = selectedRegion.value === '' || (city.region && city.region.name === selectedRegion.value);
        return matchesSearch && matchesRegion;
    })
);

const CreateCity = () => {
    router.visit(route('city.create'));
};
</script>