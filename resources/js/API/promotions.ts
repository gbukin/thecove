import axios from "axios";

export type Promotions = {
    id: number,
    title: string,
    description: string,
    body: string,
    language: string,
    picture?: string,
    created_at: string,
    updated_at?: string
}

export default function getPromotions() {
    return axios.get('/promotions/data');
}
