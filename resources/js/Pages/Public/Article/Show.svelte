<script>
    import axios from "axios";
    import PublicLayout from "../../../components/organism/layout/public/PublicLayout.svelte";
    import { onMount } from "svelte";
    export let id;
    let article;
    onMount(() => {
        axios
            .get(
                route("articles.get", {
                    article: id,
                })
            )
            .then((response) => (article = response.data));
    });
</script>

<PublicLayout>
    {#if article}
        <div>
            {#if article.url_photo}
                <img
                    src={article.url_photo}
                    alt={article.alias}
                    class="w-full h-40 object-fill"
                />
            {/if}
            <h1>{article.title}</h1>
            <div>
                <p>{@html article.body}</p>
            </div>
        </div>
    {/if}
</PublicLayout>
