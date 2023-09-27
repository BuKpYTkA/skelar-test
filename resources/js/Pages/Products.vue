<script lang="ts" setup>
    import {Product} from "@/types/Product";
    import {BasePaginator} from "@/types/BasePaginator";
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import ProductCard from "@/Components/Products/ProductCard.vue";
    import {computed, ref, watch} from "vue";
    import Pagination from "@/Components/Pagination.vue";
    import {router} from "@inertiajs/vue3";
    import {watchDebounced} from "@vueuse/core";
    import SearchIcon from "@/Components/Icons/SearchIcon.vue";
    import {Link} from '@inertiajs/vue3';

    interface ProductPaginator extends BasePaginator {
        data: Product[]
    }

    const props = defineProps<{
        paginator: ProductPaginator
    }>();

    const filter = ref({
        page: props.paginator.current_page,
        search: new URLSearchParams(window.location.href).get('search'),
    });

    const products = computed<Product[]>((): Product[] => {
        return props.paginator.data;
    });

    const onPageUpdated = (page: number) => {
        filter.value.page = page;
    };

    const loadDataWithCurrentFilter = (preserveScroll: boolean = false) => {
        router.visit(route('products.list', filter.value), {
            preserveState: true,
            preserveScroll: preserveScroll
        });
    }

    const loadDataFromFirstPage = () => {
        filter.value.page = 1;
        loadDataWithCurrentFilter();
    }

    watch(
        () => filter.value.page,
        () => loadDataWithCurrentFilter()
    );

    watchDebounced(
        () => filter.value.search,
        () => loadDataFromFirstPage(),
        {
            debounce: 500
        }
    );

</script>

<template>
    <authenticated-layout>
        <div class="flex mb-6 gap-4">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <SearchIcon/>
                </div>
                <input type="search" v-model="filter.search"
                       class="block w-full pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Search" required>
            </div>
            <Link :href="route('products.create')">
                <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Create
                </button>
            </Link>
        </div>
        <div class="grid grid-cols-3 gap-8 content-center">
            <ProductCard
                v-for="product in products"
                :product="product"
                @deleted="loadDataWithCurrentFilter(true)"
                :key="product.id"/>
        </div>
        <Pagination :paginator="paginator" @updated="onPageUpdated"/>
    </authenticated-layout>
</template>

<style scoped>

</style>
