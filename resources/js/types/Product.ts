import {User} from "@/types/index";
import {Category} from "@/types/Category";

export interface Product {
    id: number,
    title: string,
    description: string | null,
    price: number,
    category_id: number | null,
    user_id: number,
    created_at: string,
    logo_url: string | null

    user: User,
    category: Category | null
}
