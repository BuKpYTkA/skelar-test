import {ref} from "vue";
import axios from "axios";
import {createFormData} from "@/utils/formData";
import {router} from "@inertiajs/vue3";

interface ProductFormData {
    title: string,
    description: string | null,
    category_id: number | null,
    price: number,
    logo: File | null,
    logo_updated: boolean
}

interface ProductErrorMessages {
    title: Array<string>,
    description: Array<string>,
    category_id: Array<string>,
    price: Array<string>,
    logo: Array<string>
}

export function useManageProduct(submitFormUrl: string, defaultData: Partial<ProductFormData> = {}) {
    const formData = ref<ProductFormData>({
        title: '',
        description: '',
        category_id: null,
        price: 0,
        logo: null,
        logo_updated: false
    });
    formData.value = Object.assign(formData.value, defaultData);

    const errorMessages = ref<ProductErrorMessages>({
        title: [],
        description: [],
        category_id: [],
        price: [],
        logo: []
    });

    const onLogoUpdated = (fileList: FileList) => {
        formData.value.logo = fileList[0] || null;
        formData.value.logo_updated = true;
    }

    const onSubmit = () => {
        axios.post(submitFormUrl, createFormData(formData.value))
            .then(() => router.visit(route('products.list')))
            .catch(({ response }) => Object.assign(errorMessages.value, response.data.errors));
    };

    return {
        formData,
        errorMessages,
        onLogoUpdated,
        onSubmit
    }
}
