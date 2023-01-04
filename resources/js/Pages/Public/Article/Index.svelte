<script>
    import PublicLayout from "../../../components/organism/layout/public/PublicLayout.svelte";
    export let articles;

    function truncateString(str, num) {
        if (str.length > num) {
            return str.slice(0, num) + "...";
        } else {
            return str;
        }
    }
</script>

<PublicLayout>
    <div class="grid grid-cols-4 gap-4 w-full">
        {#each articles as article}
            <a href={`articulos/${article.alias}`}>
                <div class="shadow-md h-64">
                    {#if article.url_photo}
                        <img src={article.url_photo} alt="" />
                    {/if}
                    <div class="p-2">
                        <h3 class="font-bold text-xl">{article.title}</h3>
                        <p>{@html truncateString(article.body, 100)}</p>
                    </div>
                </div>
            </a>
        {/each}
    </div>
</PublicLayout>
