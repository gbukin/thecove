import axios from 'axios';

export type Language = {
    id: number,
    name: string,
    created_at: string,
}

export default function getLanguages() {
    return axios.get(route('language.data'));
}
