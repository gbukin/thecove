import axios from 'axios';

export type Promotion = {
    id: number;
    title_ru: string;
    title_en: string;
    picture?: string;
    start_at: Date;
    created_at: string;
    updated_at?: string;
};

export type PromotionData = {
    id: number,
    promotion_id: number,
    title: string,
    description_first: string,
    description_second: string,
    description_third: string,
    body: string,
    language: string,
}

interface PromotionFormStatic {
    picture: null | Blob | MediaSource;
    start_at: Date;
}

interface PromotionFormDynamic {
    [key: string]: string;
}

export type PromotionForm = PromotionFormStatic & PromotionFormDynamic

export default function getPromotions() {
    return axios.get('/promotions/data');
}
