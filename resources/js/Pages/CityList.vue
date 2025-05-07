<template>
    <Navbar/>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="text-center m-4">
            <h1 class="font-bold text-xl mb-2">Lista de Ciudades</h1>
            <button @click="CreateCity" class="bg-gray-400 py-2 px-4 rounded-lg">Crear Ciudad</button>
        </div>
        
        <div class="mb-4">
            <input type="text" v-model="search" placeholder="Buscar por nombre o región"
            class="w-full px-4 py-2 border border-black rounded-lg" />
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed">
                <thead>
                    <tr class="bg-gray-400">
                        <th class="text-left border border-black p-2">Nombre</th>
                        <th class="text-left border border-black p-2">Descripción</th>
                        <th class="text-left border border-black p-2">Región</th>
                        <th class="text-left border border-black p-2">Imagen</th>
                        <th class="text-left border border-black p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="city in filteredCities" :key="city.id">
                        <td class="text-left border border-black p-2">{{ city.name }}</td>
                        <td class="text-left border border-black p-2">{{ city.description }}</td>
                        <td class="text-left border border-black p-2">{{ city.region }}</td>
                        <td class="text-left border border-black p-2">
                            <img class="w-20" :src="`/storage/${city.image}`" :alt="city.name">
                        </td>
                        <td class="text-left border border-black p-2">
                            <div class="flex gap-2">
                                <Link :href="route('city.show', city.id)" class="text-green-600">Ver</Link>
                                <Link :href="route('city.edit', city.id)" class="text-blue-600">Editar</Link>
                                <button @click="DeleteCity(city.id)" class="text-red-600">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="props.cities && props.cities.length > 0" class="w-full max-w-4xl mx-auto mt-10">
            <div class="relative overflow-hidden rounded-xl shadow-lg"
                 @mouseenter="stopAutoplay"
                 @mouseleave="startAutoplay">
                <img
                    :src="getImageUrl(props.cities[currentIndex].image)"
                    :alt="props.cities[currentIndex].name"
                    class="w-full h-64 object-cover transition-all duration-500"
                />

                <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white p-4">
                    <div class="text-center text-lg font-semibold">
                        {{ props.cities[currentIndex].name }} - {{ props.cities[currentIndex].region || 'Sin Región' }}
                    </div>
                </div>

                <button @click="prevImage"
                    class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full hover:bg-opacity-75">
                    ‹
                </button>

                <button @click="nextImage"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full hover:bg-opacity-75">
                    ›
                </button>
            </div>

            <div class="flex justify-center mt-4 space-x-2">
                <span
                    v-for="(city, index) in props.cities"
                    :key="city.id"
                    @click="goToImage(index)"
                    class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
                    :class="{
                        'bg-gray-800': index === currentIndex,
                        'bg-gray-400': index !== currentIndex
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