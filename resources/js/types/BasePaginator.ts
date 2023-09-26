export interface BasePaginator {
    current_page: number,
    last_page: number
    per_page: number,
    total: number,
    next_page_url: string | null,
    data: any[]
}
