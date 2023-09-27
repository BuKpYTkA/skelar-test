<script lang="ts" setup>
    const props = withDefaults(defineProps<{
        error?: boolean,
        errorMessages?: Array<string>,
        label?: string,
        modelValue: any,
        items: Array<any>,
        itemTextKey: string,
        itemValueKey: string
    }>(), {
        type: 'text',
        required: false,
        error: false,
        errorMessages: () => [],
        label: '',
        placeholder: '',
        modelValue: null,
    });

    const emit = defineEmits<{
        (e: 'update:modelValue', value: any)
    }>();
</script>

<template>
    <div class="mb-6">
        <label v-if="label.length" class="block mb-2 text-sm font-medium text-gray-900">{{
                label
            }}</label>
        <select
            @change="$emit('update:modelValue', $event.target.value)"
            :value="modelValue"
            :class="[error ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700' : '']"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option
                v-for="(item, index) in items"
                :key="index"
                :selected="modelValue === item[itemValueKey]"
                :value="item[itemValueKey]"
            >{{ item[itemTextKey] }}
            </option>
        </select>
        <p v-if="errorMessages.length" class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errorMessages[0] }}</p>
    </div>
</template>

<style scoped>

</style>
