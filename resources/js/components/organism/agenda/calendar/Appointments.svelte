<script>
    import AppoinmentsList from "./AppoinmentsList.svelte";

    export let appointments;
    export let date;
    let count = appointments.length - 2 > 0 ? appointments.length - 2 : 0;

    let appointmentsFilter = appointments.slice(0, 2);
</script>

{#if appointments && appointments.length > 0}
    <!-- svelte-ignore a11y-click-events-have-key-events -->
    <div
        class="px-2 space-y-1 relative"
        on:click={() => console.log("hola mundo")}
    >
        {#each appointmentsFilter as appointment}
            <div class="flex items-center relative hover:bg-gray-300 space-x-2">
                <span class="text-xs">{appointment.start_time}</span>
                <span class="font-bold text-xs truncate">
                    {appointment.patient.name}
                </span>
            </div>
        {/each}
        {#if count > 0}
            <AppoinmentsList {appointments} hiddenQuotes={count} {date} />
        {/if}
    </div>
{/if}
