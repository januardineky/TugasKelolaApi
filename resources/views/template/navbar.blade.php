<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO App</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.7.1-web/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/datatables.min1 (1).js') }}"></script>
    <style>
        body {
            transition: margin-left 0.3s; /* Smooth transition for body */
        }
        .navbar-custom {
            background-color: #343a40;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #343a40;
            transition: 0.3s;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background-color: #0794f2;
        }
        .open-btn {
            font-size: 30px;
            cursor: pointer;
            color: white;
            margin-right: 15px;
        }
        table.dataTable thead th {
            background-color: #343a40;
            color: white;
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            width: 100%;
            bottom: 0;
        }
        #todoTable_wrapper {
    margin-bottom: 50px; /* Add space below the table */
}

#main-content {
    padding-bottom: 60px; /* Ensure space between table and footer */
}
    </style>
</head>
<body>
    @include('sweetalert::alert')
    <nav class="navbar navbar-expand-lg navbar-custom container-fluid">
        <div class="container-fluid">
            <span class="open-btn" onclick="toggleSidebar()">&#9776;</span>
            <a class="navbar-brand me-auto text-white" href="/">TODO App</a>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a class="navbar-brand text-center fs-3" href="/">TODO App</a>
        </div>
        <a href="/about">About</a>
    </div>

    <div class="container mt-5" id="main-content">
        @yield('content')
    </div>

    <!-- Footer Section -->
    <footer style="bottom: 0; position: fixed">
        <div class="container text-center">
            <p class="m-0">© 2024 TODO App. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#todoTable').DataTable();
        });

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-250px";
                document.body.style.marginLeft = "0";
            } else {
                sidebar.style.left = "0px";
                document.body.style.marginLeft = "250px";
            }
        }
    </script>
</body>
</html>
