<script>
    import { Inertia } from "@inertiajs/inertia";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import ServiceForm from "../../components/organism/service/ServiceForm.svelte";

    let service = {
        title: null,
        description: null,
        file: null,
    };

    let processing = false;

    function store() {
        Inertia.post(route("services.store"), service, {
            onStart: () => {
                processing = true;
            },
            onSuccess: () => {
                service = {
                    title: null,
                    description: null,
                    file: null,
                    image,
                };
            },
            onFinish: () => {
                processing = false;
            },
        });
    }

    function close() {
        Inertia.get(route("articles.index"));
    }
</script>

<AdminLayout>
    <ServiceForm {processing} on:save={store} on:close={close} bind:service />
</AdminLayout>
