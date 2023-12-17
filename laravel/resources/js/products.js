$(function(){

    $('#productCategoriesBtn').click(function () {
        $('#productCategoriesBtn').addClass('active');
        $('#productsIndexBtn').removeClass('active');
        $('.products-products').hide();
        $('.products-categories').show();
    })

    $('#productsIndexBtn').click(function () {
        $('#productCategoriesBtn').removeClass('active');
        $('#productsIndexBtn').addClass('active');
        $('.products-products').show();
        $('.products-categories').hide();
    })

    $('#productCreateButton').on('click', function () {
        $('#productCreateModal').toggleClass('show');
        console.log('clicked')
    });

    $('#closeProductCreateModalButton').on('click', function () {
        $('#productCreateModal').removeClass('show');
    });

    $(".editProductButton").click(function() {
        let productId = $(this).data('id')
        window.productIdForUpdate = productId;
        $("#editProductModal").css("display", "flex");
        $('.productCrudModal').hide()

        axios.get(`/api/products/${productId}`)
        .then(response => {
            let product = response.data[0]
            $('#product-update #name').val(product.name);
            $('#product-update #product_category_id').val(product.product_category_id);
            $('#product-update #price').val(product.price);
            $('#product-update #cost_price').val(product.cost_price);
            $('#product-update #vat').val(product.vat);
            $('#product-update #part_number').val(product.part_number);
            $('#product-update #quantity').val(product.quantity);

        })
        .catch(error => {
            console.error(error);
        });

    });
  
    $("#closeEditProductModal").click(function() {
        $("#editProductModal").hide();
    });

    $('.productCrudModalButton').click(function () {
        var index = $('.productCrudModalButton').index(this);
    
        $('.productCrudModal').eq(index).toggle();
    });

    $(".deleteProductButton").click(function() {
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete product'
        }).then((result) => {
            if (result.isConfirmed) {
                let productId = $(this).data('id');

                axios.delete(`/api/products/${productId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your product has been deleted.', 'success');
                        $(`#${productId}`).remove();
                    })
                    .catch(error => {
                        console.error('Error deleting product:', error);
                        Swal.fire('Error', 'Could not delete the product. Please try again.', 'error');
                    });
            }
        });
    });

    // Product store
    $('#product-store').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/products/store', formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Product created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $('#productCreateModal').removeClass('show');
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // Product update
    $('#product-update').on('submit', function (e) {
        e.preventDefault();
        console.log('submitted')

        var formData = $(this).serialize();
        var productId = window.productIdForUpdate;

        axios.post(`/api/products/update/${productId}`, formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Product updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $("#editProductModal").css("display", "none");
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // Products search
    $('#products-search').keyup(function () {
        var searchQuery = $(this).val();
        var categoryId = $('#product-categories').val();
        $.ajax({
            url: '/api/products/search',
            type: 'GET',
            dataType: 'json',
            data: { category_id: categoryId, search_query: searchQuery },
            success: function (data) {
                updateProductTable(data.products);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

    function updateProductTable(products) {
        $('tbody').empty();
        $.each(products, function (index, product) {
            var newRow = '<tr>' +
                '<td>' + product.name + '</td>' +
                '<td>' + product.product_category.name + '</td>' +
                '<td>&euro;' + product.price + '</td>' +
                '<td>' + product.quantity + '</td>' +
                '<td>&euro;' + (product.price * product.quantity) + '</td>' +
                '<td>' +
                    '<button class="productCrudModalButton"><img src="{{ asset("svg/three-dots.svg") }}" alt=""></button>' +
                    '<div class="crudModal productCrudModal">' +
                        '<button class="editProductButton">' +
                            '<img src="{{ asset("svg/pen.svg") }}" alt="">' +
                            'Edit' +
                        '</button>' +
                        '<button class="deleteProductButton">' +
                            '<img src="{{ asset("svg/trash-grey.svg") }}" alt="">' +
                            'Delete' +
                        '</button>' +
                    '</div>' +
                '</td>' +
                '</tr>';

            $('tbody').append(newRow);
        });
    }

    // Product categories filter
    $('#product-categories').change(function () {
        var categoryId = $(this).val();
        var searchQuery = $('#products-search').val();
        $.ajax({
            url: '/api/products/filter',
            type: 'GET',
            data: { category_id: categoryId, search_query: searchQuery },
            success: function (data) {
                console.log(data)
                updateProductTable(data);
            },
            error: function (error) {
                console.error('Error fetching filtered products:', error);
            }
        });
    });

    function updateProductTable(data) {
        var tbody = $('tbody');

        tbody.empty();

        data.forEach(function (product) {
            var row = '<tr>' +
                '<td>' + product.name + '</td>' +
                '<td>' + product.product_category.name + '</td>' +
                '<td>&euro;' + product.price + '</td>' +
                '<td>' + product.quantity + '</td>' +
                '<td>&euro;' + (product.price * product.quantity) + '</td>' +
                '<td>' +
                    '<button class="productCrudModalButton"><img src="{{ asset("svg/three-dots.svg") }}" alt=""></button>' +
                    '<div class="crudModal productCrudModal">' +
                        '<button class="editProductButton">' +
                            '<img src="{{ asset("svg/pen.svg") }}" alt="">' +
                            'Edit' +
                        '</button>' +
                        '<button class="deleteProductButton">' +
                            '<img src="{{ asset("svg/trash-grey.svg") }}" alt="">' +
                            'Delete' +
                        '</button>' +
                    '</div>' +
                '</td>' +
            '</tr>';

            tbody.append(row);
        });
    }

    // product categories
    $('#createProductCategoryButton').on('click', function () {
        $('#productCategoryCreateModal').toggleClass('show');
    });

    $('#closeProductCategoryCreateModalButton').on('click', function () {
        $('#productCategoryCreateModal').removeClass('show');
    });

    $(".editProductCategoryButton").click(function() {
        let productId = $(this).data('id')
        window.productIdForUpdate = productId;
        $("#editProductCategoryModal").css("display", "flex");
        $('.productCategoryCrudModal').hide()

        axios.get(`/api/productCategories/${productId}`)
        .then(response => {
            let product = response.data[0]
            $('#update-product-category-name').val(product.name);
        })
        .catch(error => {
            console.error(error);
        });

    });
  
    $("#closeEditProductCategoryModal").click(function() {
        $("#editProductCategoryModal").hide();
    });

    $('.productCategoryCrudModalButton').click(function () {
        var index = $('.productCategoryCrudModalButton').index(this);
    
        $('.productCategoryCrudModal').eq(index).toggle();
    });

    $(".deleteProductCategoryButton").click(function() {
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete product'
        }).then((result) => {
            if (result.isConfirmed) {
                let productCategoryId = $(this).data('id');

                axios.delete(`/api/productCategories/${productCategoryId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your product category has been deleted.', 'success');
                    })
                    .catch(error => {
                        console.error('Error deleting product:', error);
                        Swal.fire('Error', 'Could not delete the product. Please try again.', 'error');
                    });
            }
        });
    });

    $('#product-categories-store').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/productCategories', formData)
            .then(response => {
                $('.alert-success').text('Product category created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $('#productCategoryCreateModal').removeClass('show');
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#product-category-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    $('#product-categories-update').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var productId = window.productIdForUpdate;

        axios.patch(`/api/productCategories/${productId}`, formData)
            .then(response => {
                $('.alert-success').text('Category updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $("#editProductCategoryModal").css("display", "none");
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-product-category-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })
});