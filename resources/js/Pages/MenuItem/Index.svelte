<script>
    import SortableList from "../../components/repository/SortableList.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import {
        component,
        request,
    } from "../../components/repository/request-stores";
    import ButtonPrimary from "../../components/atoms/buttons/ButtonPrimary.svelte";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import Panel from "../../components/atoms/panel/Panel.svelte";
    import { paginate, LightPaginationNav } from "svelte-paginate";
    import MenuItem from "./MenuItem.svelte";

    export let menuItems; // Son todos los usuarios que se encuentran en la base de datos

    let currentPage = menuItems.current_page;
    let list = menuItems.data;
    export let dialog; // Es el modal que será mostrado al usuario

    $: if (dialog) {
        $request.component = dialog;
    } else {
        $request.component = null;
    }

    function create() {
        Inertia.get(route("menu-items.create"));
    }

    const sortList = (ev) => {
        list = ev.detail;
        axios.put(route("update-order-list"), {
            list: list,
        });
    };
</script>

<AdminLayout>
    <Panel class="panel-full">
        <div class="py-2">
            <ButtonPrimary on:click={create}>Nuevo item de menú</ButtonPrimary>
        </div>
        <div class="border grid grid-cols-5 py-4 px-2">
            <div>Nombre</div>
            <div>Link</div>
            <div>Fecha de creación</div>
            <div>Fecha de actualización</div>
        </div>
        <SortableList {list} key="order" on:sort={sortList} let:item let:index>
            <MenuItem {item} {index} />
        </SortableList>

        <div class="mt-4">
            <LightPaginationNav
                totalItems={menuItems.total}
                pageSize={menuItems.per_page}
                {currentPage}
                limit={1}
                showStepOptions={true}
                on:setPage={(e) => {
                    Inertia.get(
                        route("menu-items.index", { page: e.detail.page })
                    );
                    currentPage = e.detail.page;
                }}
            />
        </div>
        {#if component}
            <svelte:component this={$component} />
        {/if}
    </Panel>
</AdminLayout>
