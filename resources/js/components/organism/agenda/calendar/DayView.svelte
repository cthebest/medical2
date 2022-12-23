<script>
    import moment from "moment/moment";
    import { page } from "@inertiajs/inertia-svelte";
    import { showAppointmentsDay } from "../../../repository/appointments-day.js";
    import axios from "axios";
    export let day, label;

    export let action = null;

    let date;
    let hours = [];
    let resource_user = $page.props.query.resource_user;
    let appointments = [];
    $: if (day) {
        date = moment(day);
        getOfficeHour();
    } else {
        date = moment();
        getOfficeHour();
    }

    $: if (action === "nextDate") {
        nextDay();
    } else if (action === "prevDate") {
        prevDay();
    }

    function nextDay() {
        date.add(1, "day");
        getOfficeHour();
        action = null;
    }

    function prevDay() {
        date.subtract(1, "day");
        getOfficeHour();
        action = null;
    }

    function getOfficeHour() {
        hours = [];
        document
            .querySelectorAll(".appointment-schedule")
            .forEach((el) => el.remove());
        appointments = [];
        axios
            .all([
                axios.get(
                    route("agenda.get-office-hour-view", {
                        resource_user: $page.props.query.resource_user,
                        date: date.format("YYYY-MM-DD"),
                    })
                ),
                axios.get(
                    route("appointments-by-date", {
                        date: date.format("YYYY-MM-DD"),
                        resource_user: resource_user,
                    })
                ),
            ])
            .then(
                axios.spread((response_office_hour, response_appointments) => {
                    label = date.format("LL");
                    buildHours(response_office_hour.data);

                    appointments = response_appointments.data;
                })
            );
    }

    function buildHours(data) {
        data.officeHours.forEach((hour) => {
            hours = hours.concat(buildIntervals(hour, data.duration));
        });
    }

    function buildIntervals(hour, duration) {
        const start_time = moment(hour.start_time, "h:mm A");
        const end_time = moment(hour.end_time, "h:mm A");

        let partialTime = [];
        // Nos permitirá guardar el primer elemento para comparar
        let start_time_temp = start_time.clone();
        while (start_time.isBefore(end_time)) {
            let isBetween = false;
            if (timeIsBetween(start_time, start_time_temp)) {
                isBetween = true;
            } else {
                start_time_temp = start_time.clone();
            }

            partialTime.push({
                time: start_time.format("h:mm A"),
                isBetween: isBetween,
            });
            start_time.add(parseInt(duration), "minutes");

            if (start_time.isSameOrAfter(end_time)) {
                if (!timeIsBetween(start_time, start_time_temp)) {
                    isBetween = false;
                }

                partialTime.push({
                    time: start_time.format("h:mm A"),
                    isBetween: isBetween,
                });

                break;
            }
        }

        return partialTime;
    }

    function timeIsBetween(start_time, start_time_temp) {
        return (
            start_time.isAfter(start_time_temp) &&
            start_time.isBefore(start_time_temp.clone().add(1, "hour"))
        );
    }
</script>

{#if appointments.length > 0}
    <div
        class="border-l border-r border-b relative"
        use:showAppointmentsDay={appointments}
    >
        {#each hours as hour}
            <div
                class="border-t p-2 text-xs"
                data-time={hour.time}
                class:border-dashed={hour.isBetween}
            >
                {hour.time}
            </div>
        {/each}
    </div>
{:else}
    <span>No hay citas agendadas para este día</span>
{/if}
