<script>
    import Footer from "./Footer.svelte";
    import PublicNavbar from "./PublicNavbar.svelte";
  
    
</script>

<svelte:head>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    />
</svelte:head>
<PublicNavbar></PublicNavbar>

<main class="flex flex-col min-h-screen">
    <div class="flex-1 container mx-auto px-4">
        <slot />
    </div>
    
    <Footer></Footer>
</main>

