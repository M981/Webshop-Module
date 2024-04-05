function filterProducts(categoryId) {
    window.location.href = 'index.php?category_id=' + categoryId;
}

document.addEventListener("DOMContentLoaded", function() {
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const params = new URLSearchParams(window.location.search);
    const checkedCategories = params.getAll('category_id');

    // Check checkboxes based on URL parameters
    categoryCheckboxes.forEach(checkbox => {
        if (checkedCategories.includes(checkbox.value)) {
            checkbox.checked = true;
        }
        checkbox.addEventListener('change', updateFilters);
    });

    // Initial filtering based on checked checkboxes
    filterProducts(checkedCategories);

    // Function to update filters and trigger filtering
    function updateFilters() {
        const checkedCategories = Array.from(categoryCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        filterProducts(checkedCategories);
    }

    // Function to filter products based on selected categories
    function filterProducts(categories) {
        const categoryQueryString = categories.length > 0 ? '?category_id=' + categories.join(',') : '';
        
        // Check if any categories are selected
        if (categoryQueryString !== window.location.search) {
            window.location.href = 'index.php' + categoryQueryString;
        }
    }
});
