<script>
    import AgendaHeader from "./AgendaHeader.svelte";
    import { view_component } from "../../../repository/request-stores";

    let action = null;
    let label = null;
    export let professional;
</script>

<div class="mt-5">
    <!--Obtengo los días del mes-->
    <AgendaHeader
        on:nextDate={() => (action = "nextDate")}
        on:prevDate={() => (action = "prevDate")}
        {label}
    />
    {#if $view_component}
        <svelte:component
            this={$view_component}
            bind:action
            bind:label
            {professional}
        />
    {/if}
</div>
