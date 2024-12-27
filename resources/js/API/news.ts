import axios from "axios";

export type News = {
    id: number,
    title_ru: string,
    title_en: string,
    created_at: string,
    updated_at?: string
}

interface Search {
    id?: string,
    title_ru?: string,
    title_en?: string,
}

export default function getNews(data: {sortColumn: string, sortDirection: string, search?: Search}) {
    const uri = '/news/data?'
    const sort = 'sortColumn=' + data.sortColumn + '&sortDirection=' + data.sortDirection
    let search = ''

    if (data.search) {
        search = '&search[id]=' + data.search.id
            + '&search[title_ru]=' + data.search.title_ru
            + '&search[title_en]=' + data.search.title_en
    }

    return axios.get(uri + sort + search);
}
