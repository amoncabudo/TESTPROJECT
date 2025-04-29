<template>
    <div class="text-center text-5xl p-4" @click="Welcome">
        Lista de City
    </div>
    <div class="text-center text-xl p-4">
        <button @click="CreateCity" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear City
        </button>
    </div>
    <div class="p-8">

        <table class="w-full border ">
            <tbody >
                <tr class="bg-gray-400 text-left">
                    <th class="p-2 border border-black">Name</th>
                    <th class="p-2 border border-black">Description</th>
                    <th class="p-2 border border-black">Image</th>
                    <th class="p-2 border border-black">Acciones</th>
                </tr>
                <tr v-for="city in cities" :key="city.id">
                    <td class="p-2 border border-black">{{ city.name }}</td>
                    <td class="p-2 border border-black">{{ city.description }}</td>
                    <td class="p-2 border border-black"><img class="w-10" :src="`/storage/${city.image}`" :alt="city.name"></td>
                    <td class="p-2 border border-black">
                        <div>
                        <Link :href="route('city.show', city.id)" class="text-green-500"> Ver </Link>
                        <Link :href="route('city.edit', city.id)" class="text-blue-500"> Editar </Link>
                        <button @click="DeleteCity(city.id)" class="text-red-500">Eliminar </button>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    cities: Array,
});

function DeleteCity(id){
    router.delete(route('city.destroy', id))
}
function Welcome(){
    router.visit('/');
}

function CreateCity(){
    router.visit('city/create');
}

</script>