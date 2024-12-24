@extends('template.navbar')

@section('content')

    <!-- Flash Messages with SweetAlert -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Button to Open Add Todo Modal -->
    <div class="mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTodoModal">Add New List</button>
    </div>

    <!-- Table for Todos -->
    <table id="todoTable" class="display">
        <thead>
            <tr>
                <th>Todo</th>
                <th>Status</th>
                <th>User ID</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $todo)
                <tr>
                    <td>{{ $todo['todo'] }}</td>
                    <td>{{ $todo['completed'] ? 'Finished' : 'Not Finished' }}</td>
                    <td>{{ $todo['userId'] }}</td>
                    <td>{{ $todo['created_at'] }}</td>
                    <td>{{ $todo['updated_at'] }}</td>
                    <td>
                        <!-- Edit Link -->
                        <a href="#" class="btn btn-primary text-white p-2" title="Edit" onclick="openEditModal('{{ $todo['_id'] }}')">
                            <i class="fas fa-edit"></i>
                        </a>
                        <!-- Delete Link -->
                        <a href="/delete/{{ $todo['_id'] }}"class="btn btn-danger text-white"title="Delete" onclick="return confirm('Are you sure you want to delete this item?')">
                             <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add Todo Modal -->
    <div class="modal fade" id="addTodoModal" tabindex="-1" aria-labelledby="addTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTodoModalLabel">Add New Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTodoForm" action="/add" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="todoName" class="form-label">Todo Name</label>
                            <input type="text" class="form-control" id="todoName" name="todo" required>
                        </div>
                        <div class="mb-3">
                            <label for="completed" class="form-label">Completed</label>
                            <select class="form-select" id="completed" name="completed" required>
                                <option value="false">Not Finished</option>
                                <option value="true">Finished</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Todo Modal -->
    <div class="modal fade" id="editTodoModal" tabindex="-1" aria-labelledby="editTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTodoModalLabel">Edit Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTodoForm" action="/update/{{ $todo['_id'] }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="editTodoName" class="form-label">Todo Name</label>
                            <input type="text" class="form-control" id="editTodoName" name="todo" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCompleted" class="form-label">Completed</label>
                            <select class="form-select" id="editCompleted" name="completed" required>
                                <option value="false">Not Finished</option>
                                <option value="true">Finished</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Open the modal for editing a todo item
        function openEditModal(todoId) {
    $.get(`/edit/${todoId}`, function(response) {
        if (response.error) {
            alert(response.error);
            return;
        }

        const todo = response.data.find(item => item._id === todoId);

        if (todo) {
            $('#editTodoName').val(todo.todo);
            $('#editCompleted').val(todo.completed.toString());
            $('#editTodoForm').attr('action', `/update/${todo._id}`); // Form akan menggunakan POST
            $('#editTodoModal').modal('show');
        } else {
            alert('Todo not found.');
        }
    }).fail(function() {
        alert('Failed to fetch todo data.');
    });
}


    </script>

@endsection
