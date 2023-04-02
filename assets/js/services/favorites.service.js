const FAVORITES_KEY = 'favorites';
import mitt from 'mitt';

class FavoritesService {
    constructor() {
        this.emitter = mitt();
        this.favorites = JSON.parse(localStorage.getItem(FAVORITES_KEY)) || [];
    }

    getFavorites() {
        return this.favorites;
    }

    addFavorite(fruit) {
        this.favorites.push(fruit);
        localStorage.setItem(FAVORITES_KEY, JSON.stringify(this.favorites));
        this.emitter.emit('favorites-updated', this.getFavorites().length);

    }

    isInFavorites(fruit) {
        const index = this.favorites.findIndex(f => f.id === fruit.id);
        return index >= 0;
    }

    removeFavorite(favoriteId) {
        const index = this.favorites.findIndex(f => f.id === favoriteId);
        if (index !== -1) {
            this.favorites.splice(index, 1);
            localStorage.setItem(FAVORITES_KEY, JSON.stringify(this.favorites));
        }
    }

    $on(event, handler) {
        this.emitter.on(event, handler);
    }

    $off(event, handler) {
        this.emitter.off(event, handler);
    }
}

export default new FavoritesService();
