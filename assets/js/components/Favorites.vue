<template>
    <div class="container mt-4">

        <h1 class="mb-4">Favorite Fruits

            <button class="btn btn-secondary " style="margin-left: 20px;" @click="$router.back()">
                Back
            </button>
        </h1>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4" v-for="favorite in favorites" :key="favorite.id">
                    <div class="card-body">
                        <h5 class="card-title">{{ favorite.name }}</h5>
                        <p class="card-text">
                            Nutrition: {{ favorite.nutritions.calories }} calories, {{ favorite.nutritions.fat }} fat, {{
                                favorite.nutritions.carbohydrates }}g carbohydrates, {{ favorite.nutritions.protein }} protein,
                            {{ favorite.nutritions.sugar }} sugar
                        </p>
                        <button class="btn btn-danger" @click="removeFavorite(favorite.id)">Remove from favorites</button>
                    </div>
                </div>

                <div v-if="favorites.length === 0">
                    <p>You have no favorite fruits yet.</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Nutrition Facts</h5>
                        <p class="card-text">
                            Calories: {{ totalNutrition.calories.toFixed(2) }}<br>
                            Fat: {{ totalNutrition.fat.toFixed(2) }}<br>
                            Carbohydrates: {{ totalNutrition.carbohydrates.toFixed(2) }}<br>
                            Protein: {{ totalNutrition.protein.toFixed(2) }}<br>
                            Sugar: {{ totalNutrition.sugar.toFixed(2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import FavoritesService from "../services/favorites.service.js";

export default {
    name: "Favorites",
    data() {
        return {
            favorites: [],
            totalNutrition: {},
        };
    },
    created() {
        this.loadFavorites();
        this.calculateTotalNutrition();
    },
    methods: {
        loadFavorites() {
            this.favorites = FavoritesService.getFavorites();
        },
        removeFavorite(id) {
            const confirmed = window.confirm("Are you sure you want to remove this fruit from favorites?");
            if (confirmed) {
                FavoritesService.removeFavorite(id);
                this.loadFavorites();
                this.calculateTotalNutrition();
            }

        },
        calculateTotalNutrition() {
            const favorites = FavoritesService.getFavorites();
            let calories = 0;
            let fat = 0;
            let carbohydrates = 0;
            let protein = 0;
            let sugar = 0;
            for (let favorite of favorites) {
                calories += favorite.nutritions.calories;
                fat += favorite.nutritions.fat;
                carbohydrates += favorite.nutritions.carbohydrates;
                protein += favorite.nutritions.protein;
                sugar += favorite.nutritions.sugar;
            }
            this.totalNutrition = { calories, fat, carbohydrates, protein, sugar };
        },
    },
};
</script>
  