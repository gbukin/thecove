import axios from "axios";

export type Participator = {
    id: number,
    full_name: string,
    phone: string,
    check_number: string,
    check_sum: string,
    check_time: string,
    created_at: string,
}

export default function getParticipators() {
    return axios.get('/participators/data');
}
