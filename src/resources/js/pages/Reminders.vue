<template>
    <div class="md:max-w-2xl m-5 max-w-md mx-auto">
        <div class="flex justify-between mb-4">
            <div class="text-4xl">Upcoming Reminders</div>
            <fwb-button color="default" size="md" type="button">
                Add Reminder
            </fwb-button>
        </div>
        <reminder-card
            v-for="reminder in reminders"
            :reminder="reminder"
            :key="reminder.id"
        />
    </div>
</template>

<script lang="js" setup>
import { FwbButton } from "flowbite-vue";
import ReminderCard from "../components/ReminderCard.vue";

import { apiGetReminders, apiCreateReminder, apiUpdateReminder, apiDeleteReminder  } from "../api/reminder"
import { onMounted, reactive } from "vue";

onMounted(() => {
    getReminders();
});

const reminders = reactive([]);

const getReminders = () => {
    apiGetReminders()
        .then((response) => {
            let remindersData = response.data.data.reminders;
            Object.assign(reminders, remindersData);
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
