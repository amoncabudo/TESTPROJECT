<template>
    <div class="text-center mt-8">
        <button @click="ListaCity" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Ver Lista
        </button>
        <button @click="CreateCity" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear City
        </button>
    </div>
</template>

<script setup>
import{ router } from '@inertiajs/vue3';

function ListaCity(){
    router.visit('/city');
}

function CreateCity(){
    router.visit('/city/create');
}

</script>