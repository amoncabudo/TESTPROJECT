<template>
    <Navbar/>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-medium text-gray-800">Lista de Ciudades</h1>
            <button @click="CreateCity" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md text-sm transition-colors">
                Crear Ciudad
            </button>
        </div>
        
        <div class="mb-6">
            <input 
                type="text" 
                v-model="search" 
                placeholder="Buscar por nombre o región"
                class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" aria-label="Buscador"
            />
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Región</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="city in filteredCities" :key="city.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ city.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ city.description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ city.region }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img class="h-16 w-16 object-cover rounded" :src="`/storage/${city.image}`" :alt="city.name">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-3">
                                <Link :href="route('city.show', city.id)" class="text-green-600 hover:text-indigo-900">Ver</Link>
                                <Link :href="route('city.edit', city.id)" class="text-blue-600 hover:text-blue-900">Editar</Link>
                                <button @click="DeleteCity(city.id)" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="props.cities && props.cities.length > 0" class="mt-10 bg-white rounded-lg shadow overflow-hidden">
            <div class="relative"
                 @mouseenter="stopAutoplay"
                 @mouseleave="startAutoplay">
                <img
                    :src="getImageUrl(props.cities[currentIndex].image)"
                    :alt="props.cities[currentIndex].name"
                    class="w-full h-64 object-cover transition-all duration-500"
                />

                <div class="absolute bottom-0 w-full bg-gradient-to-t from-black/70 to-transparent text-white p-4">
                    <div class="text-center text-lg font-medium">
                        {{ props.cities[currentIndex].name }} - {{ props.cities[currentIndex].region || 'Sin Región' }}
                    </div>
                </div>

                <button @click="prevImage"
                    class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white w-8 h-8 flex items-center justify-center rounded-full transition-colors">
                    ‹
                </button>

                <button @click="nextImage"
                    class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white w-8 h-8 flex items-center justify-center rounded-full transition-colors">
                    ›
                </button>
            </div>

            <div class="flex justify-center my-4 space-x-2">
                <span
                    v-for="(city, index) in props.cities"
                    :key="city.id"
                    @click="goToImage(index)"
                    class="w-2 h-2 rounded-full cursor-pointer transition-all duration-300"
                    :class="{
                        'bg-indigo-600': index === currentIndex,
                        'bg-gray-300': index !== currentIndex
                    }"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    cities: Array
});

const city = ref(props.cities);

function CreateCity(){
    router.visit('/city/create');
}

function DeleteCity(id) {
    router.delete(route('city.destroy', id), {
        preserveScroll: true,
        onSuccess: () => {
            city.value = city.value.filter(city => city.id !== id);
        }
    });
}

// Buscador
const search = ref('');
const filteredCities = computed(() =>
    props.cities.filter(city =>
        city.name.toLowerCase().includes(search.value.toLowerCase()) ||
        (city.region && city.region.toLowerCase().includes(search.value.toLowerCase()))
    )
);

// Slider
const currentIndex = ref(0);
const autoplayInterval = ref(null);
const isPaused = ref(false);

const nextImage = () => {
    if (props.cities.length > 0) {
        currentIndex.value = (currentIndex.value + 1) % props.cities.length;
    }
};

const prevImage = () => {
    if (props.cities.length > 0) {
        currentIndex.value = (currentIndex.value - 1 + props.cities.length) % props.cities.length;
    }
};

const goToImage = (index) => {
    if (props.cities.length > 0) {
        currentIndex.value = index;
    }
};

const getImageUrl = (imagePath) => {
    return `/storage/${imagePath}`;
};

const startAutoplay = () => {
    if (!autoplayInterval.value && !isPaused.value) {
        autoplayInterval.value = setInterval(nextImage, 3000);
    }
};

const stopAutoplay = () => {
    if (autoplayInterval.value) {
        clearInterval(autoplayInterval.value);
        autoplayInterval.value = null;
    }
};

onMounted(() => {
    startAutoplay();
});

onUnmounted(() => {
    stopAutoplay();
});
</script>