<template>
    <div>

        <button class="btn btn-sm btn-outline-danger" :class="{ 'active': favorited }">
            <i class="bi bi-heart mr-1"></i>
            {{ favoritesCount }}
        </button>

    </div>
</template>
  
<script>
export default {
    name: 'FavoritesIcon',
    props: {
        favoritesCount: {
            type: Number,
            default: 0,
        },
    },
};
</script>
  