import axios from 'axios';

export type Promotion = {
    id: number;
    title: string;
    description: string;
    body: string;
    language: string;
    picture?: string;
    start_at: Date;
    created_at: string;
    updated_at?: string;
};

export default function getPromotions() {
    return axios.get('/promotions/data');
}
