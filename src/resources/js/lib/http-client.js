import axios from "axios";
import { getCookie, removeCookie } from "@/lib/cookie";

const url = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

const accessToken = getCookie("access_token");
const refreshToken = getCookie("refresh_token");

const globalResponseHandler = (response) => response;

const globalErrorHandler = (error) => {
    // const status = error?.response?.status;
    // const isTokenExpired = status === 401;

    // const origin = window?.location?.origin;

    // if (isTokenExpired) {
    //     const currentURL = window?.location?.pathname;
    //     let nextURL = "";
    //     if (currentURL?.includes("control-tower")) {
    //         nextURL = `${origin}/control-tower`;
    //     } else {
    //         nextURL = "";
    //     }
    //     removeCookie("token");
    //     localStorage.clear();
    //     const originalRequest = error.config;
    //     delete originalRequest?.headers?.Authorization;
    //     history.pushState(null, "", nextURL);
    // }
    return Promise.reject(error);
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
