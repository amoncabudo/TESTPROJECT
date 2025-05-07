<template>
    <div class="text-xl p-4 text-center">
        Show de {{ cities.name }}
    </div>
    <div class="p-8 text-center text-black ">
        <table class="w-full">
            <tbody>
                <tr class="bg-gray-400 text-left">
                    <th class="p-2 border border-black">Nom</th>
                    <th class="p-2 border border-black">Descripció</th>
                    <th class="p-2 border border-black">Regió</th>
                    <th class="p-2 border border-black">Imatge</th>
                </tr>

                <tr class="border-t">
                    <td class="p-2 border border-black">{{ cities.name }}</td>
                    <td class="p-2 border border-black">{{ cities.description }}</td>
                    <td class="p-2 border border-black">{{ cities.region }}</td>

                    <td class="p-2 border border-black"><img class="w-20" :src="`/storage/${cities.image}`" :alt="cities.name">
                    </td>

                </tr>
                <tr>
                    <td colspan="7" class="p-2 text-center"></td>
                </tr>
            </tbody>

        </table>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    cities: Object,
});

</script>