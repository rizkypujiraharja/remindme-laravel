import client from "@/lib/http-client";

const baseURL = "reminders";

const apiGetReminders = () => {
    return client().get(`${baseURL}`, { params: { limit: 15 } });
}

const apiCreateReminder = (reminder) => {
    return client().post(`${baseURL}`, reminder);
}

const apiUpdateReminder = (reminder) => {
    return client().put(`${baseURL}/${reminder.id}`, reminder);
}

const apiDeleteReminder = (reminder) => {
    return client().delete(`${baseURL}/${reminder.id}`);
}

export { apiGetReminders, apiCreateReminder, apiUpdateReminder, apiDeleteReminder };
