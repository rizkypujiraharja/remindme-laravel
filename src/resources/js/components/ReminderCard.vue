<template>
    <div class="mx-auto bg-white rounded-xl shadow-md overflow-hidden m-5">
        <div class="p-6 pb-2 flex flex-row">
            <div>
                <div
                    class="flex items-center justify-center pr-4 bg-orange-400 p-2 rounded-lg text-center basis-1/4"
                >
                    <div>
                        <p class="text-4xl font-bold text-white">
                            {{ getDateWithExtension(reminder.event_at) }}
                        </p>
                        <p class="text-sm text-white">
                            {{ getMonthAndYearFromSecond(reminder.event_at) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="ml-4 basis-3/4">
                <div
                    class="uppercase tracking-wide text-sm text-indigo-500 font-semibold"
                >
                    {{ reminder.title }}
                </div>
                <p class="mt-2 text-gray-700">
                    {{ getHourAndMinuteFromSecond(reminder.event_at) }}
                </p>
                <p class="mt-2 text-gray-500 text-sm">
                    {{ reminder.description }}
                </p>

                <fwb-button
                    color="alternative"
                    size="sm"
                    outline
                    class="text-blue-400 underline px-0 mr-4"
                >
                    Edit
                </fwb-button>

                <fwb-button
                    @click="deleteReminder(reminder)"
                    color="alternative"
                    size="sm"
                    outline
                    class="text-red-400 underline px-0"
                >
                    Delete
                </fwb-button>
            </div>
        </div>
    </div>
</template>

<script lang="js" setup>
import { FwbButton } from "flowbite-vue";
import { apiDeleteReminder } from "../api/reminder";
import dayjs from "dayjs";

const props = defineProps({
    reminder: {
        type: Object,
        required: true,
    },
});

const getDateFromSeconds = (date) => {
    return dayjs.unix(date).format("DD");
};

const getDateExtension = (date) => {
    if(date % 10 === 1) {
        return "st";
    } else if(date % 10 === 2) {
        return "nd";
    } else if(date % 10 === 3) {
        return "rd";
    } else {
        return "th";
    }
};

const getDateWithExtension = (seconds) => {
    const date = getDateFromSeconds(seconds);
    return `${date}${getDateExtension(date)}`;
};

const getMonthAndYearFromSecond = (seconds) => {
    return dayjs.unix(seconds).format("MMMM, YYYY");
};

const getHourAndMinuteFromSecond = (seconds) => {
    return dayjs.unix(seconds).format("hh:mm A");
};

const emit = defineEmits(['deletedReminder'])

const deleteReminder = (reminder) => {
    const confirmation = confirm("Are you sure you want to delete this reminder?");

    if(!confirmation) {
        return;
    }

    apiDeleteReminder(reminder)
        .then((response) => {
            emit('deletedReminder', reminder)
        })
        .catch((error) => {
            console.log(error);
        });


};
</script>
