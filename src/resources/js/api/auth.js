import client from "@/lib/http-client";

const baseURL = "session";

const apiLogin = (email, password) => {
    return client().post(`${baseURL}`, { email, password });
}

export { apiLogin };
