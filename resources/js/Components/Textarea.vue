<script lang="ts" setup>
    import {TextInputProps} from "@/types/Input";

    const props = withDefaults(defineProps<TextInputProps>(), {
        type: 'text',
        error: false,
        errorMessages: () => [],
        label: '',
        placeholder: '',
        modelValue: '',
    });

    const emit = defineEmits<{
        (e: 'update:modelValue', value: string)
    }>();
</script>

<template>
    <div class="mb-6">
        <label v-if="label.length" class="block mb-2 text-sm font-medium text-gray-900">{{ label }}</label>
        <textarea :type="type"
                  @input="$emit('update:modelValue', $event.target.value)"
                  :class="[error ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700' : '']"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  :value="modelValue"
                  :placeholder="placeholder"/>
        <p v-if="errorMessages.length" class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errorMessages[0] }}</p>
    </div>
</template>

<style scoped>

</style>
