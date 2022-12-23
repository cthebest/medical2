<script>
    import { createPopper } from "@popperjs/core";
    export let appointments = []; // Arreglo original
    export let hiddenQuotes = 0;
    export let date;
    let dropdownPopoverShow = false;
    let btnDropdownRef;
    let popoverDropdownRef;

    function showAppointments() {
        dropdownPopoverShow = !dropdownPopoverShow;
        if (dropdownPopoverShow) {
            createPopper(btnDropdownRef, popoverDropdownRef, {
                placement: "top",
                modifiers: [
                    {
                        name: "offset",
                        options: {
                            offset: [-20, 0],
                        },
                    },
                ],
            });
        }
    }
</script>

<button
    class="text-xs w-full"
    on:click={showAppointments}
    bind:this={btnDropdownRef}
>
    +{hiddenQuotes} más
</button>
<div
    bind:this={popoverDropdownRef}
    class="w-[200px] bg-white border border-gray-400"
    class:hidden={!dropdownPopoverShow}
>
    <div class="flex justify-between bg-gray-200 items-center z-50">
        <span class="font-bold text-xs px-2">{date}</span>
        <button class="hover:bg-gray-300 px-2" on:click={showAppointments}
            >x</button
        >
    </div>
    <ul class="px-2 shadow-sm max-h-20 overflow-y-auto h-20">
        {#each appointments as appointment}
            <li class="hover:bg-gray-200 text-xs my-1">
                {appointment.start_time}
                <span class="font-bold">{appointment.patient.name}</span>
            </li>
        {/each}
    </ul>
</div>
