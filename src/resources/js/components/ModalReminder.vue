<template>
    <fwb-modal v-if="isShowModal" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg">
                {{ isCreate ? "Create" : "Edit" }} Reminder
            </div>
        </template>
        <template #body>
            <form class="space-y-2 md:space-y-6">
                <fwb-input
                    v-model="reminder.title"
                    required
                    placeholder="enter reminder title"
                    label="Title"
                />
                <fwb-input
                    v-model="reminder.description"
                    required
                    placeholder="enter reminder description"
                    label="Description"
                />
                <fwb-input
                    type="datetime-local"
                    v-model="reminder.event_at"
                    required
                    label="Event At"
                />
                <fwb-input
                    type="datetime-local"
                    v-model="reminder.remind_at"
                    required
                    label="Remind At"
                />
            </form>
        </template>
        <template #footer>
            <fwb-button @click="submit" color="default">
                {{ isCreate ? "Create" : "Update" }}
            </fwb-button>
            <fwb-button @click="closeModal" color="alternative" class="ml-4">
                Cancel
            </fwb-button>
        </template>
    </fwb-modal>
</template>

<script lang="js" setup>
import { defineProps, computed } from "vue";
import { FwbButton, FwbModal, FwbInput } from "flowbite-vue";
import { apiCreateReminder, apiUpdateReminder } from "../api/reminder";

const props = defineProps({
    isShowModal: Boolean,
    reminder: {},
});

const isCreate = computed(() => !props.reminder.id);

const emit = defineEmits(["closeModal", "updatedReminder", "createdReminder"]);

const closeModal = () => {
    emit("closeModal");
};

const submit = () => {
    const eventAt = new Date(props.reminder.event_at).getTime() / 1000;
    const remindAt = new Date(props.reminder.remind_at).getTime() / 1000;
    if (isCreate.value) {
        apiCreateReminder({
            ...props.reminder,
            event_at: eventAt,
            remind_at: remindAt,
        }).then((response) => {
            emit("submited");
            closeModal();
        });
    } else {
        apiUpdateReminder({
            ...props.reminder,
            event_at: eventAt,
            remind_at: remindAt,
        }).then((response) => {
            emit("submited");
            closeModal();
        });
    }
};
</script>
