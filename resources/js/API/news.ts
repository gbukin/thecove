import axios from 'axios';

export type News = {
    id: number;
    title_ru: string;
    title_en: string;
    show: boolean;
    created_at: string;
    updated_at?: string;
};

export type NewsData = {
    id: number,
    news_id: number,
    title: string,
    announce: string,
    text: string,
    language: string,
}

interface Search {
    id?: string;
    title_ru?: string;
    title_en?: string;
    show?: string;
}

interface NewsFormStatic {
    picture: null | Blob | MediaSource;
    show: boolean;
}

interface NewsFormDynamic {
    [key: string]: string;
}

export type NewsForm = NewsFormStatic & NewsFormDynamic;

function convertSearchShowToInt(
    searchShow: string | undefined
): number | undefined {
    if (searchShow === 'Yes') {
        return 1;
    }

    if (searchShow === 'No') {
        return 0;
    }

    return undefined;
}

export default function getNews(data: {
    sortColumn: string;
    sortDirection: string;
    search?: Search;
}) {
    const uri = '/news/data?';
    const sort =
        'sortColumn=' +
        data.sortColumn +
        '&sortDirection=' +
        data.sortDirection;
    let search = '';

    if (data.search) {
        search =
            '&search[id]=' +
            data.search.id +
            '&search[title_ru]=' +
            data.search.title_ru +
            '&search[title_en]=' +
            data.search.title_en +
            '&search[show]=' +
            convertSearchShowToInt(data.search.show);
    }

    return axios.get(uri + sort + search);
}
