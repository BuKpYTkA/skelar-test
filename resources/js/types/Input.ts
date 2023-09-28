export interface BaseInputProps {
    error: boolean,
    errorMessages: Array<string>,
    label: string
}

export interface TextInputProps extends BaseInputProps {
    type?: string,
    placeholder?: string,
    modelValue: string,
}
