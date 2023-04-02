<template>
    <!-- Pagination -->
    <nav aria-label="Fruits pagination">
        <ul class="pagination">
            <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                <button class="page-link" @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">
                    Previous
                </button>
            </li>

            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ 'active': page === currentPage }">
                <button class="page-link" @click="goToPage(page)">{{ page }}</button>
            </li>

            <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                <button class="page-link" @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">
                    Next
                </button>
            </li>
        </ul>
    </nav>
</template>
  
<script>
export default {
    name: 'Pagination',

    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        totalPages: {
            type: Number,
            required: true,
            default: 1
        },
        pagesToShow: {
            type: Number,
            default: 5,
        },
    },

    computed: {
        showPreviousLink() {
            return this.currentPage > 1;
        },

        showNextLink() {
            return this.currentPage < this.totalPages;
        },

        pageNumbers() {
            const startPage = Math.max(this.currentPage - Math.floor(this.pagesToShow / 2), 1);
            const endPage = Math.min(startPage + this.pagesToShow - 1, this.totalPages);

            return Array(endPage - startPage + 1).fill().map((_, index) => startPage + index);
        },
    },

    methods: {
        goToPage(pageNumber) {
            if (pageNumber < 1 || pageNumber > this.totalPages) {
                return;
            }

            this.$emit('page-changed', pageNumber);
        },
    },
};
</script>
  