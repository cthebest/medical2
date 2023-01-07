<script>
    import { onMount } from "svelte";
    import img_header from "images/inicio/img_header.png";
    import Footer from "./Footer.svelte";
    // Hola mundo

    let menuItems = [];

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

<svelte:head>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    />
</svelte:head>
<div class="mx-40">
    <header>
        <img src={img_header} alt="" class="w-full" />
        <nav class="bg-[#006699] px-5 py-2">
            <ul class="text-white flex space-x-5">
                {#each menuItems as menuItem}
                    <li class="flex flex-col justify-center items-center">
                        {#if menuItem.icon}
                            <div
                                class="flex 
                            justify-center items-center"
                            >
                                <i class={menuItem.icon} />
                            </div>
                        {/if}
                        <a href={menuItem.path}>{menuItem.title}</a>
                    </li>
                {/each}
            </ul>
        </nav>
    </header>
</div>

<main class="flex mx-40 mt-5">
    <slot />
</main>

<Footer></Footer>
