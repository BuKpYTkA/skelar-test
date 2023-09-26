<script lang="ts" setup>
    import {Product} from "@/types/Product";
    import {computed} from "vue";

    const props = defineProps<{
        product: Product
    }>();

    const price = computed<number>((): number => {
        return props.product.price / 100;
    })
</script>

<template>
    <div class="max-w-sm rounded overflow-hidden shadow-lg mb-4 flex flex-col">
        <img class="w-full" src="https://placehold.co/600x400" alt="Sunset in the mountains">
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
                        product.category.title
                    }}</span>
                <p class="inline-block ml-auto px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                    {{ product.user.name }}</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .card_description {
        max-height: 150px;
        overflow:hidden;
        white-space: nowrap;
        width: 100%;
        text-overflow: ellipsis;
    }
</style>
