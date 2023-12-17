import axios from "axios";
import { getCookie, setCookie, removeCookie } from "@/lib/cookie";

const url = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

const accessToken = getCookie("access_token");
const refreshToken = getCookie("refresh_token");

const globalResponseHandler = (response) => response;

const globalErrorHandler = async (error) => {
    const originalRequest = error.config;
    const status = error?.response?.status;
    const err = error?.response?.data.err;
    const isTokenExpired = status === 401 && err === "ERR_INVALID_ACCESS_TOKEN" && refreshToken;

    if (!isTokenExpired) {
        return Promise.reject(error);
    } else if (!refreshToken) {
        window.location.href = "/login";
    }

    try {
        const response = await axios.put("/api/session", null, {
            headers: {
                Authorization: `Bearer ${refreshToken}`,
            },
        });

        const data = response.data.data;
        setCookie("access_token", data.access_token, 20);

        originalRequest.headers.Authorization = `Bearer ${data.access_token}`;

        return axios(originalRequest);
    } catch (err) {
        removeCookie('access_token');
        removeCookie('refresh_token');
        window.location.href = "/login";
    }
};

const clientConfig = () =>
    axios.create({
        baseURL: url,
        headers: {
            Authorization: `Bearer ${accessToken}`,
        },
    });

const client = () => {
    const axiosClient = clientConfig();
    axiosClient.interceptors.response.use(
        globalResponseHandler,
        globalErrorHandler
    );
    return axiosClient;
};

export default client;
