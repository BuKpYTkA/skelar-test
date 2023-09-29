<script lang="ts" setup>
    import {Product} from "@/types/Product";
    import {computed} from "vue";
    import {Link} from '@inertiajs/vue3';
    import axios from "axios";

    const DEFAULT_IMAGE_URL = 'https://placehold.co/600x400';

    const props = defineProps<{
        product: Product
    }>();

    const emit = defineEmits<{
        (e: 'deleted')
    }>()

    const price = computed<number>((): number => {
        return props.product.price / 100;
    });

    const deleteProduct = (): void => {
        axios.delete(route('products.delete', {
            product: props.product.id
        })).then(() => emit('deleted'));
    }
</script>

<template>
    <div class="max-w-sm rounded overflow-hidden shadow-lg mb-4 flex flex-col">
        <img class="w-full product_logo" :src="product.logo_url || DEFAULT_IMAGE_URL" alt="Sunset in the mountains">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">{{ product.title }}</div>
            <p class="text-gray-700 text-base card_description">
                {{ product.description }}
            </p>
        </div>
        <div class="flex mt-auto flex-col">
            <div class="px-6 py-2 mt-auto">
                <p class="font-bold text-red-500">{{ price }} UAH</p>
            </div>
            <div class="px-6 pb-2 flex justify-between mt-auto">
                <span v-if="product.category_id"
                      class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{
                        product.category?.title
                    }}</span>
                <p class="inline-block ml-auto px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                    {{ product.user.name }}</p>
            </div>
            <div class="px-6 pb-2 flex justify-center gap-4 mt-auto">
                <Link :href="route('products.update', {product: product.id})">
                    <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Edit
                    </button>
                </Link>
                <button type="button"
                        @click="deleteProduct"
                        class="px-5 text-sm font-medium text-white focus:outline-none bg-red-500 rounded-lg border border-gray-200 hover:bg-red-700 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-200">
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .card_description {
        max-height: 150px;
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
        text-overflow: ellipsis;
    }

    .product_logo {
        min-height: 256px;
        max-height: 256px;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .product_logo {
            min-height: 150px;
            max-height: 150px;
        }

    }
</style>
