<script lang="ts" setup>
    import {Product} from "@/types/Product";
    import {BasePaginator} from "@/types/BasePaginator";

    interface ProductPaginator extends BasePaginator {
        data: Product[]
    }

    const props = defineProps<{
        paginator: ProductPaginator
    }>()
</script>

<template>
    <p>hello</p>
</template>

<style scoped>

</style>
