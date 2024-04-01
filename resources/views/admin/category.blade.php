<h2 class="bg-primary text-white p-2">Management Category</h2>
<div class="text-left">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCategoryModal">Create Category</button>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Category Name</th>
            <th scope="col">Update</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($Categories as $index => $category)
            <tr class="align-middle">
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $category->name }}</td>
                <td>
                    <button class="btn btn-primary update-category-btn" data-bs-toggle="modal"
                        data-bs-target="#updateCategoryModal" data-category-id="{{ $category->id }}">Update</button>
                </td>
                <td>
                    <button class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Create Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.post.category') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category name:</label>
                        <input type="text" class="form-control" id="categoryName" name="category_name">
                        @error('category_name')
                            <p class="notify-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.update.category', ['id' => $category->id]) }}" method="POST">
                @csrf
                {{-- @method('PUT') --}}
                <div class="modal-body">
                    <input type="hidden" id="updateCategoryId" name="category_id">
                    <div class="mb-3">
                        <label for="updateCategoryName" class="form-label">New category name:</label>
                        <input type="text" class="form-control" id="updateCategoryName" name="category_name"
                            placeholder={{ $category->name }}>
                        @error('category_name')
                            <p class="notify-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    {{-- @method('DELETE')
                    @csrf --}}
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
