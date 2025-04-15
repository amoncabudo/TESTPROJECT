<template>
    <!-- Define el título de la página en el navegador -->
    <Head title="Comida" />


    <!-- Contenedor principal con margen y padding -->
    <div class="container mx-auto p-4">
        <!-- Cabecera con título y botón de agregar -->
        <div class="flex justify-between mb-4">
            <!-- Título de la página -->
            <h1 class="text-xl font-bold">Comida</h1>
            
            <!-- Enlace para crear nuevo producto -->
            <Link :href="route('comida.create')" class="bg-blue-500 text-white p-2 rounded">
                Agregar
            </Link>
        </div>

        <!-- Mensaje de éxito que aparece cuando hay una operación exitosa -->
        <div v-if="$page.props.flash?.success" class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ $page.props.flash.success }}
        </div>

        <!-- Tabla simple para mostrar los comida -->
        <table class="w-full border">
            <!-- Encabezado de la tabla -->
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Nombre</th>
                    <th class="p-2 text-left">Descripcion</th>
                    <th class="p-2 text-left">Image</th>
                    <th class="p-2 text-left">Acciones</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla con los datos de comida -->
            <tbody>
                <!-- Ciclo que recorre cada producto en el array -->
                <tr v-for="comida in comidas" :key="comida.id" class="border-t">
                    <!-- Celdas con información del producto -->
                    <td class="p-2">{{ comida.id }}</td>
                    <td class="p-2">{{ comida.name }}</td>
                    <td class="p-2">{{ comida.description }}</td>
                    <td class="p-2">{{ comida.image }}</td>
                    <!-- Celda con botones de acción -->
                    <td class="p-2">
                        <div class="flex gap-2">
                            <!-- Enlace para ver detalles del producto -->
                            <Link :href="route('comida.show', comida.id)" class="text-blue-500">Ver</Link>
                            <!-- Enlace para editar el producto -->
                            <Link :href="route('comida.edit', comida.id)" class="text-yellow-500">Editar</Link>
                            <!-- Botón para eliminar el producto -->
                            <button @click="eliminarComida(comida.id)" class="text-red-500">Eliminar</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
// Importamos los componentes necesarios de Inertia
import { Head, Link, router } from '@inertiajs/vue3';
// Importamos el componente de navegación

// Definimos las props que recibe este componente (datos de comida)
const props = defineProps({
    comidas: Array // Array de comida que viene del controlador
});

// Función para eliminar un producto
function eliminarComida(id) {
    // Confirmación antes de eliminar
    if (confirm('¿Estás seguro de eliminar este producto?')) {
        // Enviamos la petición DELETE al servidor con el ID del producto
        router.delete(route('comida.destroy', id));
    }
}
</script>