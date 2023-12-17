<template>
    <div>
        <div class="md:max-w-2xl m-5 max-w-md mx-auto">
            <div class="flex justify-between mb-4">
                <div class="text-4xl">Upcoming Reminders</div>
                <fwb-button
                    color="default"
                    size="md"
                    type="button"
                    @click="showCreateModal"
                >
                    Add Reminder
                </fwb-button>
            </div>
            <reminder-card
                v-for="reminder in reminders"
                :reminder="reminder"
                :key="reminder.id"
                @deletedReminder="deletedReminder"
                @showEditModal="showEditModal"
            />
        </div>
        <modal-reminder
            :isShowModal="isShowModal"
            :reminder="reminder"
            @closeModal="closeModal"
            @submited="getReminders"
        />
    </div>
</template>

<script lang="js" setup>
import { FwbButton } from "flowbite-vue";
import ReminderCard from "../components/ReminderCard.vue";
import ModalReminder from "../components/ModalReminder.vue";

import { apiGetReminders } from "../api/reminder"
import { onMounted, reactive, ref } from "vue";
import dayjs from "dayjs";

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

const deletedReminder = (reminder) => {
    const indexReminder = reminders.findIndex((data) => data.id === reminder.id);
    reminders.splice(indexReminder, 1);
};

const isShowModal = ref(false);
const reminder = reactive({});

const setEmptyReminder = () => {
    Object.assign(reminder, {
        id: null,
        title: "",
        description: "",
        event_at: null,
        remind_at: null,
    });
};

const showCreateModal = () => {
    isShowModal.value = true;
    setEmptyReminder();
};

const showEditModal = (editedReminder) => {
    isShowModal.value = true;
    editedReminder.event_at = dayjs.unix(editedReminder.event_at).format("YYYY-MM-DDTHH:mm");
    editedReminder.remind_at = dayjs.unix(editedReminder.remind_at).format("YYYY-MM-DDTHH:mm");
    Object.assign(reminder, editedReminder);
};

const closeModal = () => {
    isShowModal.value = false;
    setEmptyReminder();
};
</script>
