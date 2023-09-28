<script lang="ts" setup>
    import {BasePaginator} from "@/types/BasePaginator";
    import {computed} from "vue";
    import RightArrowIcon from "@/Components/Icons/RightArrowIcon.vue";
    import LeftArrowIcon from "@/Components/Icons/LeftArrowIcon.vue";

    const DEFAULT_NUMBER_OF_DYNAMIC_PAGES: number = 3;
    const ACTIVE_PAGE_CLASS_LIST: string = 'relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm' +
        ' font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2' +
        ' focus-visible:outline-offset-2 focus-visible:outline-indigo-600';
    const DEFAULT_PAGE_CLASS_LIST: string = 'relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900' +
        ' ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex'

    const props = defineProps<{
        paginator: BasePaginator,
    }>();

    const emit = defineEmits<{
        (e: 'updated', value: number)
    }>();

    const isFirstPageActive = computed<boolean>((): boolean => {
        return props.paginator.current_page === 1;
    });

    const isLastPageActive = computed<boolean>((): boolean => {
        return props.paginator.current_page === props.paginator.last_page;
    });

    const activePagePosition = computed<number>((): number => {
        if (!isFirstPageActive.value && !isLastPageActive.value) {
            return defaultActivePagePosition.value
        }
        if (isFirstPageActive.value) {
            return 1;
        }

        return currentNumberOfPages.value;
    });

    const defaultActivePagePosition = computed<number>((): number => {
        return currentNumberOfPages.value % 2
            ? (currentNumberOfPages.value + 1) / 2
            : currentNumberOfPages.value / 2;
    })

    const prevButtonClass = computed<string>((): string => {
        return props.paginator.prev_page_url ? 'text-gray-600' : 'text-gray-200 pagination_nav_disabled';
    });

    const nextButtonClass = computed<string>((): string => {
        return props.paginator.next_page_url ? 'text-gray-600' : 'text-gray-200 pagination_nav_disabled';
    });

    const showFirstDots = computed<boolean>((): boolean => {
        return props.paginator.current_page - defaultActivePagePosition.value > 1;
    });

    const showFirstPage = computed<boolean>((): boolean => {
        return !mainPageSet.value.includes(1);
    });

    const showLastPage = computed<boolean>((): boolean => {
        return !mainPageSet.value.includes(props.paginator.last_page);
    })

    const showSecondDots = computed<boolean>((): boolean => {
        return props.paginator.last_page - defaultActivePagePosition.value > props.paginator.current_page
    });

    const currentNumberOfPages = computed<number>((): number => {
        return props.paginator.last_page > DEFAULT_NUMBER_OF_DYNAMIC_PAGES
            ? DEFAULT_NUMBER_OF_DYNAMIC_PAGES
            : props.paginator.last_page
    })

    const mainPageSet = computed<Array<number>>((): Array<number> => {
        return [...Array(currentNumberOfPages.value).keys()].map(value =>
            value + props.paginator.current_page - activePagePosition.value + 1
        );
    });

    const setPage = (page: number) => {
        if (page > 0 && page <= props.paginator.last_page) {
            emit('updated', page);
        }
    }
</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#"
               class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#"
               class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ paginator.from }}</span>
                    to
                    <span class="font-medium">{{ paginator.to }}</span>
                    of
                    <span class="font-medium">{{ paginator.total }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#"
                       @click.prevent="setPage(paginator.current_page - 1)"
                       :class="prevButtonClass"
                       class="relative inline-flex items-center rounded-l-md px-2 py-2 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <LeftArrowIcon/>
                    </a>
                    <a v-if="showFirstPage"
                       href="#"
                       @click.prevent="setPage(1)"
                       :class="[paginator.current_page === 1 ? ACTIVE_PAGE_CLASS_LIST : DEFAULT_PAGE_CLASS_LIST]"
                       aria-current="page">
                        1
                    </a>
                    <span v-if="showFirstDots"
                          class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                    <a v-for="page in mainPageSet" :key="page"
                       href="#"
                       @click.prevent="setPage(page)"
                       :class="[paginator.current_page === page ? ACTIVE_PAGE_CLASS_LIST : DEFAULT_PAGE_CLASS_LIST]"
                       aria-current="page">
                        {{ page }}
                    </a>
                    <span v-if="showSecondDots"
                          class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                    <a v-if="showLastPage"
                       href="#"
                       @click.prevent="setPage(paginator.last_page)"
                       aria-current="page"
                       :class="[paginator.current_page === paginator.last_page ? ACTIVE_PAGE_CLASS_LIST : DEFAULT_PAGE_CLASS_LIST]">
                        {{ paginator.last_page }}
                    </a>
                    <a href="#"
                       @click.prevent="setPage(paginator.current_page + 1)"
                       :class="nextButtonClass"
                       class="relative inline-flex items-center rounded-r-md px-2 py-2 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <RightArrowIcon/>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
    .pagination_nav_disabled {
        pointer-events: none;
    }
</style>
