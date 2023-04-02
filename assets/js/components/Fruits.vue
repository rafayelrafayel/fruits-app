<template>
    <div class="container mt-5">
        <h1>Fruits</h1>
        <hr>

        <!-- Filter form -->
        <form class="form-inline mb-4">
            <div class="form-group mr-2">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" v-model="nameFilter">
            </div>

            <div class="form-group mr-2">
                <label for="family">Family:</label>
                <input type="text" class="form-control" id="family" v-model="familyFilter">
            </div>

            <button type="submit" class="btn btn-primary" @click.prevent="applyFilter">Filter</button>

            <div class="col-md-3 favorites-div" @click="$router.push('/favorites')">
                Favorites
                <FavoritesIcon :favorites-count="favoritesCount" />
            </div>
        </form>

        <!-- Fruits list -->
        <div v-if="loading">Loading...</div>
        <div v-else class="row">


            <div class="col-md-4 mb-4" v-for="fruit in fruits" :key="fruit.id">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ fruit.name }}</h5>
                        <p class="card-text">{{ fruit.description }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Family: {{ fruit.family }}</li>
                            <li class="list-group-item">Carbohydrates: {{ fruit.nutritions.carbohydrates }}</li>
                            <li class="list-group-item">Fat: {{ fruit.nutritions.fat }}</li>
                            <li class="list-group-item">Protein: {{ fruit.nutritions.protein }}</li>
                            <li class="list-group-item">Calories: {{ fruit.nutritions.calories }}</li>
                            <li class="list-group-item">Sugar: {{ fruit.nutritions.sugar }}</li>
                            <li class="list-group-item">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    @click.prevent="addToFavorites(fruit)">
                                    Add to favorites
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!filteredFruits || (filteredFruits && !filteredFruits.length)">No fruits found.</div>
        <!-- Display the pagination controls -->


        <pagination :current-page="currentPage"
            :total-pages="totalFruits < perPage ? 1 : (totalFruits % perPage === 0) ? Math.round(totalFruits / perPage) : Math.round(totalFruits / perPage) + 1"
            @page-changed="paginateFruits">
        </pagination>


    </div>
</template>



<script>

import Pagination from '../components/Pagination.vue';
import FavoritesIcon from '../components/FavoritesIcon.vue';
import fruitsService from '../services/fruits.service';
import favoritesService from '../services/favorites.service';

export default {
    name: 'Fruits',

    components: {
        Pagination,
        FavoritesIcon

    },

    data() {
        return {
            fruits: [],
            filteredFruits: [],
            nameFilter: '',
            familyFilter: '',
            loading: false,
            currentPage: 1,
            perPage: 10,
            totalFruits: 0,
            favoritesCount: favoritesService.getFavorites().length
        }
    },

    mounted() {
        this.fetchFruits();
        favoritesService.$on('favorites-updated', (count) => {
            this.favoritesCount = count;
        });
    },



    methods: {
        fetchFruits(pageNumber) {
            console.log(pageNumber);
            this.loading = true;
            fruitsService.search(this.nameFilter, this.familyFilter, this.currentPage, this.perPage).then((response) => {

                this.fruits = response.data.fruits;
                this.totalFruits = response.data.count;
                this.filterFruits();
            }).catch(error => console.error(error))
                .finally(() => this.loading = false);

        },
        selectPage(pageNum) {
            this.currentPage = pageNum
        },
        paginateFruits(pageNumber) {
            this.currentPage = pageNumber
            this.fetchFruits()
        },
        applyFilters() {
            this.currentPage = 1
            this.fetchFruits()
        },

        filterFruits() {
            let filteredFruits = this.fruits

            if (this.nameFilter) {
                filteredFruits = filteredFruits.filter(fruit => fruit.name.toLowerCase().includes(this.nameFilter.toLowerCase()))
            }

            if (this.familyFilter) {
                filteredFruits = filteredFruits.filter(fruit => fruit.family.toLowerCase().includes(this.familyFilter.toLowerCase()))
            }

            this.filteredFruits = filteredFruits
        },
        async updateFavoritesCount() {
            const favorites = await favoritesService.getFavorites();
            this.favoritesCount = favorites.length;
        },

        addToFavorites(fruit) {
            if (favoritesService.getFavorites().length === 10) {
                alert(`Maximum 10 favorites allowed`);
                return;
            }
            if (!favoritesService.isInFavorites(fruit)) {
                favoritesService.addFavorite(fruit);
                alert(`${fruit.name} added to favorites!`);
            } else {
                alert(`${fruit.name} already in favorites!`);
            }

        }
    },

    computed: {

        pageCount() {
            return Math.ceil(this.totalItems / this.itemsPerPage)
        },


    },

    watch: {
        currentPage() {
            this.fetchFruits()
        },

        nameFilter() {
            this.applyFilters()
        },

        familyFilter() {
            this.applyFilters()
        }
    }
}
</script>
  