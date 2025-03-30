<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concession</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #444;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #007bff;
        }
        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }
        .form-container, .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 45%;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #218838;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        td img {
            border-radius: 5px;
        }
        .icon-btn {
            cursor: pointer;
            font-size: 18px;
            margin: 0 5px;
            transition: color 0.3s ease;
        }
        .icon-btn.editIcon {
            color: #ffc107;
        }
        .icon-btn.editIcon:hover {
            color: #e0a800;
        }
        .icon-btn.deleteIcon {
            color: #dc3545;
        }
        .icon-btn.deleteIcon:hover {
            color: #c82333;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Manage Concessions</h1>
    <div class="container">
        <div class="form-container">
            <form id="concessionForm">
                <div class="form-group">
                    <label for="name">Name (required)</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image (required)</label>
                    <input type="file" id="image" name="image" required>
                </div>
                <div class="form-group">
                    <label for="price">Price (required)</label>
                    <input type="number" id="price" name="price" required>
                </div>
                <button type="submit" class="btn">Add Concession</button>
            </form>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="concessionTable">
                    @foreach($concessions as $concession)
                    <tr data-id="{{ $concession->id }}">
                        <td>{{ $concession->name }}</td>
                        <td>{{ $concession->description }}</td>
                        <td><img src="{{ asset($concession->image) }}" alt="{{ $concession->name }}" width="50"></td>
                        <td>{{ $concession->price }}</td>
                        <td>
                            <i class="fas fa-edit icon-btn editIcon"></i>
                            <i class="fas fa-trash icon-btn deleteIcon"></i>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
$(document).ready(function () {
    // Set CSRF token in AJAX headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Form submission for both create and update
    $('#concessionForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        // Check if we're updating (has hidden _method field)
        var isUpdate = formData.has('_method') && formData.get('_method') === 'PUT';
        var url = isUpdate 
            ? '{{ url("concession") }}/' + formData.get('id')
            : '{{ route("concession.store") }}';
        
        $.ajax({
            type: 'POST', // Always use POST for form submissions with FormData
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.success
                }).then(function () {
                    location.reload();
                });
            },
            error: function (response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.responseJSON.message
                });
            }
        });
    });

    // Edit button click handler
    $('.editIcon').on('click', function () {
        var tr = $(this).closest('tr');
        var id = tr.data('id');
        var name = tr.find('td:eq(0)').text();
        var description = tr.find('td:eq(1)').text();
        var price = tr.find('td:eq(3)').text();

        // Reset the form first (remove any previous hidden fields)
        $('#concessionForm').find('input[name="_method"]').remove();
        $('#concessionForm').find('input[name="id"]').remove();
        
        // Set form values
        $('#name').val(name);
        $('#description').val(description);
        $('#price').val(price);
        
        // Add hidden fields for method and ID
        $('#concessionForm').append('<input type="hidden" name="_method" value="PUT">');
        $('#concessionForm').append('<input type="hidden" name="id" value="' + id + '">');
        
        // Change button text
        $('#concessionForm button[type="submit"]').text('Update Concession');
    });

    // Delete button click handler
    $('.deleteIcon').on('click', function () {
        var id = $(this).closest('tr').data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url("concession") }}/' + id,
                    data: {
                        '_method': 'DELETE'
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.success
                        }).then(function () {
                            location.reload();
                        });
                    },
                    error: function (response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.message
                        });
                    }
                });
            }
        });
    });
});
    </script>
</body>
</html>