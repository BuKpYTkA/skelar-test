<script lang="ts" setup>
    import {ref} from "vue";
    import {BaseInputProps} from "@/types/Input";

    interface FileUploaderProps extends BaseInputProps {
        accept: string,
    }

    const props = withDefaults(defineProps<FileUploaderProps>(), {
        accept: '*',
        error: false,
        errorMessages: () => [],
        label: '',
    });

    const emit = defineEmits<{
        (e: 'updated', value: FileList): void;
    }>();

    const fileInputRef = ref<HTMLInputElement | null>(null);

    const onChange = () => {
        if (!fileInputRef.value) {
            return;
        }

        const files = fileInputRef.value.files;
        if (!files) {
            return;
        }
        emit('updated', files);
    }
</script>

<template>
    <div class="mb-6">
        <label v-if="label.length" class="block mb-2 text-sm font-medium text-gray-900">{{ label }}</label>
        <input
            ref="fileInputRef"
            :class="[error ? 'bg-red-50 border-red-500' : '']"
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
            :accept="accept"
            @change="onChange"
            type="file">
        <p v-if="errorMessages.length" class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errorMessages[0] }}</p>
    </div>
</template>

<style scoped>

</style>
