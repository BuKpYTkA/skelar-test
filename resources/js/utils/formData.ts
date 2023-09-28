export function createFormData(data: any): FormData {
    const formData = new FormData();
    Object.keys(data).forEach(key => {
        const item = data[key];
        item instanceof File
            ? formData.append(key, item, item.name)
            : formData.append(key, item === null ? '' : item)
    });

    return formData;
}
