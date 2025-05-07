<template>
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Editar Ciudad</h1>

        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="name" class="block mb-1">name:</label>
                    <input type="text" id="name" v-model="form.name" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="description" class="block mb-1">description:</label>
                    <input type="text" id="description" v-model="form.description" class="w-full border p-2 rounded"
                        required />
                </div>
                <div class="mb-3">
                    <label for="region" class="block mb-1">Región/Continente:</label>
                    <select id="region" v-model="form.region" class="w-full border p-2 rounded" required>
                        <option value="">Selecciona una región</option>
                        <option value="Europa">Europa</option>
                        <option value="Asia">Asia</option>
                        <option value="América">América</option>
                        <option value="África">África</option>
                        <option value="Oceanía">Oceanía</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="block mb-1">Imagen:</label>
                    <input type="file" id="image" @input="handleImageChange" class="w-full border p-2 rounded"
                        accept="image/*" />
                    <div class="p-2 text-left">
                        <img v-if="previewImage" class="w-20" :src="previewImage" :alt="form.name">
                        <img v-else-if="props.city.image" class="w-20" :src="`/storage/${props.city.image}`" :alt="props.city.name">
                    </div>
                </div>

                <div class="flex justify-between mt-4">
                    <Link :href="route('city.index')" class="bg-gray-300 px-3 py-1 rounded">
                    Cancelar
                    </Link>
                    <button type="submit" class="bg-blue-500 text-black px-3 py-1 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';

const props = defineProps({
    city: {
        type: Object,
        required: true
    }
});

const previewImage = ref(null);

const form = useForm({
    name: '',
    description: '',
    region: '',
    image: null,
    _method: 'put'
});

const handleImageChange = (event) => {
    const file = event.target.files[0];
    form.image = file;

    if (file) {
        previewImage.value = URL.createObjectURL(file);
    }
};

onMounted(() => {
    if (props.city) {
        form.name = props.city.name;
        form.description = props.city.description;
        form.region = props.city.region;
        form.image = props.city.image;
    }
});

function submit() {
    form.post(route('city.update', props.city.id));
}
</script>