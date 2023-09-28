<script lang="ts" setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import {Category} from "@/types/Category";
    import Input from "@/Components/Input.vue";
    import BaseDropdown from "@/Components/BaseDropdown.vue";
    import Textarea from "@/Components/Textarea.vue";
    import {Product} from "@/types/Product";
    import FileUploader from "@/Components/FileUploader.vue";
    import {useManageProduct} from "@/composables/useManageProduct";

    const props = defineProps<{
        categories: Category[],
        product: Product
    }>();

    const {
        formData,
        errorMessages,
        onLogoUpdated,
        onSubmit
    } = useManageProduct(route('products.save', {
        product: props.product.id
    }), {
        title: props.product.title,
        description: props.product.description,
        category_id: props.product.category_id,
        price: props.product.price,
    });

    const onReset = () => {
        formData.value.title = props.product.title;
        formData.value.price = props.product.price;
        formData.value.description = props.product.description;
        formData.value.category_id = props.product.category_id;
    };

</script>

<template>
    <authenticated-layout>
        <form @submit.prevent="onSubmit" @reset.prevent="onReset">
            <Input
                label="Title"
                placeholder="Your title"
                required
                v-model="formData.title"
                :error-messages="errorMessages.title"
                :error="!!errorMessages.title.length"
            />
            <Input
                label="Price"
                type="number"
                placeholder="Your price"
                required
                v-model="formData.price"
                :error-messages="errorMessages.price"
                :error="!!errorMessages.price.length"
            />
            <BaseDropdown
                :item-text-key="'title'"
                :item-value-key="'id'"
                :items="categories"
                v-model="formData.category_id"
                :error-messages="errorMessages.category_id"
                :error="!!errorMessages.category_id.length"
                label="Category"
            />
            <FileUploader
                accept="image/*"
                @updated="onLogoUpdated"
                label="Logo"
                :error-messages="errorMessages.logo"
                :error="!!errorMessages.logo.length"
            />
            <Textarea
                label="Description"
                placeholder="Your description"
                :error-messages="errorMessages.description"
                :error="!!errorMessages.description.length"
                v-model="formData.description"
            />
            <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Submit
            </button>
            <button type="reset"
                    class="py-2.5 px-5 mr-2 mb-2 ml-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                Reset
            </button>
        </form>
    </authenticated-layout>
</template>

<style scoped>

</style>
