import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('productSearch', () => ({
    loading: false,
    debounceTimer: null,

    fetchResults() {
        clearTimeout(this.debounceTimer);
        this.loading = true;

        const params = new URLSearchParams(new FormData(this.$refs.form));
        const url = `${this.$refs.form.action}?${params.toString()}`;

        window.axios.get(url)
            .then((response) => {
                document.getElementById('products-results').innerHTML = response.data;
                window.history.replaceState({}, '', url);
            })
            .finally(() => {
                this.loading = false;
            });
    },

    debouncedFetch() {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => this.fetchResults(), 400);
    },
}));

Alpine.start();