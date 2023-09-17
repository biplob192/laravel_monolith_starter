<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">





    <!-- AJAX CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><strong>USERS (server side render)</strong></h5>
                            <div class="float-sm-right ml-1">
                                <button type="button" class="btn btn-block btn-default">
                                    <a href="{{route('users.export')}}">
                                        <p style="margin: 0; padding: 0">
                                            Export Users
                                        </p>
                                    </a>
                                </button>
                            </div>
                            <div class="float-sm-right ml-1">
                                <button type="button" class="btn btn-block btn-default">Sample</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>ID</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>ID</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var table;
        $(document).ready(function() {
        table = new DataTable('#example', {
        ajax: 'get/data',
        responsive: true,
        // processing: true,
        serverSide: true,
        columnDefs: [
        {
            // defaultContent: "-",
            // targets: "_all",
        // targets: 0,
        render: function (data, type, row) {
        if(data){
        return '<a href="/show/' + row[3] + '">' + data + '</a>';
        }
        },
        orderable: true,
        },
        {
        targets: -2, // Edit button
        render: function (data, type, row) {
        return '<a href="#" class="btn btn-primary edit-button" data-id="' + row[3] + '">Edit</a>';
        },
        orderable: false,
        },
        {
        targets: -1, // Delete button
        render: function (data, type, row) {
        // return '<button class="delete-button" data-id="' + row[3] + '">Delete</button>';
        return '<a href="#" class="btn btn-danger delete-button" data-id="' + row[3] + '">Delete</a>';
        },
        orderable: false,
        },
        ],
        });
        });

        $('#example').on('click', '.delete-button', function () {
        var userId = $(this).data('id');
        var $rowToDelete = $(this).closest('tr'); // Get the row to delete

        // Display a SweetAlert confirmation dialog
        Swal.fire({
        title: 'Confirm Deletion',
        text: 'Are you sure you want to delete this record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
        cancelButtonColor: '#d33',
        }).then((result) => {
        if (result.isConfirmed) {
        // User confirmed the deletion
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        url: 'destroy/' + userId,
        type: 'DELETE',
        success: function (response) {
        console.log(response)
        // Remove the row from the DataTable
        table.row($rowToDelete).remove().draw(false);
        },
        error: function (xhr, status, error) {
        console.log(error)
        },
        });
        } else {
        }
        });
        });
    </script>
</body>

</html>
