<script>
    import { Inertia } from "@inertiajs/inertia";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import ServiceForm from "../../components/organism/service/ServiceForm.svelte";

    let processing;
    export let service;
    function store() {
        Inertia.post(
            route("services.update", { service: service.id }),
            {
                _method: "put",
                title: service.title,
                description: service.description,
                file: service.file,
                resource: service.resource,
            },
            {
                onStart: () => (processing = true),
                onFinish: () => (processing = false),
            }
        );
    }

    function close() {
        Inertia.get(route("services.index"));
    }
</script>

<AdminLayout>
    {#if service}
        <ServiceForm
            {processing}
            on:save={store}
            on:close={close}
            bind:service
        />
    {/if}
</AdminLayout>
