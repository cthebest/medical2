<script>
    import { onMount } from "svelte";
    let menuItems = [];
    let isOpenedMenu = false;
    onMount(() => getElements());
    function getElements() {
        axios.all([axios.get(route("menu-items.get-all"))]).then(
            axios.spread((menuItemsResponse) => {
                // output of req.
                menuItems = menuItemsResponse.data;
                console.log(menuItems);
            })
        );
    }
</script>

<header class="bg-[#006699] px-4 py-2">
    <nav
        class="
         flex flex-wrap
         items-center
         justify-between
         w-full         
         md:py-0
         container
         mx-auto
         px-4
         text-lg text-white"
    >
        <div>
            <a href="#">
                <img
                    src="../images/logoenoe.png"
                    alt="logo"
                    class="w-40 object-cover"
                />
            </a>
        </div>

        <button
            class="block md:hidden"
            on:click={() => (isOpenedMenu = !isOpenedMenu)}
        >
            <i class="fa-solid fa-bars" />
        </button>
        <div
            class="w-full md:flex md:items-center md:w-auto"
            id="menu"
            class:hidden={!isOpenedMenu}
        >
            <ul
                class="pt-4
                text-base text-white
                md:flex
                md:justify-between 
                md:pt-0"
            >
                {#each menuItems as menuItem}
                    <li>
                        <a
                            class="md:p-4 py-2 block hover:text-[#c7f768]"
                            href={menuItem.path}
                        >
                            {menuItem.title}
                        </a>
                    </li>
                {/each}
            </ul>
        </div>
    </nav>
</header>
