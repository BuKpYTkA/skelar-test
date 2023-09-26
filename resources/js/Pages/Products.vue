<script lang="ts" setup>
    import {Product} from "@/types/Product";
    import {BasePaginator} from "@/types/BasePaginator";
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import ProductCard from "@/Components/Products/ProductCard.vue";
    import {computed} from "vue";
    import Pagination from "@/Components/Pagination.vue";

    interface ProductPaginator extends BasePaginator {
        data: Product[]
    }

    const props = defineProps<{
        paginator: ProductPaginator
    }>();

    const products = computed<Product[]>((): Product[] => {
        return props.paginator.data;
    });
</script>

<template>
    <authenticated-layout>
        <div class="flex justify-between flex-wrap">
            <ProductCard v-for="product in products" :product="product" :key="product.id"/>
        </div>
        <Pagination :paginator="paginator"/>
    </authenticated-layout>
</template>

<style scoped>

</style>
