import axios from "axios";

const baseUrl = import.meta.env.VITE_API_BASE_URL;

export const http = axios.create({
    withCredentials: true,
    baseURL: baseUrl,
    headers: { 
        "X-Requested-With": "XMLHttpRequest", 
        "withCredentials": "true",
        "Access-Control-Allow-Origin": "*"
},
});
