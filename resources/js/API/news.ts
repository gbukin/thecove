import axios from "axios";

export type News = {
    id: number,
    title_ru: string,
    title_en: string,
    show: boolean,
    date: string,
    updated_at?: string
}

interface Search {
    id?: string,
    title_ru?: string,
    title_en?: string,
    show?: string,
}

function convertSearchShowToInt(searchShow): number|null {
    if (searchShow === 'Yes') {
        return 1;
    }

    if (searchShow === 'No') {
        return 0;
    }

    return undefined;
}

export default function getNews(data: {sortColumn: string, sortDirection: string, search?: Search}) {
    const uri = '/news/data?'
    const sort = 'sortColumn=' + data.sortColumn + '&sortDirection=' + data.sortDirection
    let search = ''

    if (data.search) {
        search = '&search[id]=' + data.search.id
            + '&search[title_ru]=' + data.search.title_ru
            + '&search[title_en]=' + data.search.title_en
            + '&search[show]=' + convertSearchShowToInt(data.search.show)
    }

    return axios.get(uri + sort + search);
}
