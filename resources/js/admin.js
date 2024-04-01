document.addEventListener('DOMContentLoaded', function () {
    const updateButtons = document.querySelectorAll('.update-category-btn');

    updateButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var categoryId = this.getAttribute('data-category-id');
            document.getElementById('updateCategoryId').value = categoryId;
        });
    });

    const deleteButtons = document.querySelectorAll('.btn-danger');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            $('#confirmDeleteModal').modal('show');
            const categoryId = button.parentElement.parentElement.querySelector('.update-category-btn').dataset.categoryId;
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = '/categories/' + categoryId;
        });
    });
});
