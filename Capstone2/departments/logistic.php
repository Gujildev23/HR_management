<?php
$tasksFile = 'logistic_taks.json'; // Change the file name for each department
$tasks = json_decode(file_get_contents($tasksFile), true);

// Handling form submissions for adding, editing, and deleting tasks
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addTask'])) {
        $newTask = [
            "id" => "PC-T" . rand(1000, 9999),
            "task" => $_POST['task'],
            "owner" => $_POST['owner'],
            "status" => $_POST['status'],
            "start_date" => $_POST['start_date'],
            "due_date" => $_POST['due_date'],
            "completion" => $_POST['completion'],
            "priority" => $_POST['priority'],
            "duration" => $_POST['duration']
        ];
        $tasks[] = $newTask;
    }

    if (isset($_POST['editTask'])) {
        foreach ($tasks as &$task) {
            if ($task['id'] === $_POST['id']) {
                $task['task'] = $_POST['task'];
                $task['owner'] = $_POST['owner'];
                $task['status'] = $_POST['status'];
                $task['start_date'] = $_POST['start_date'];
                $task['due_date'] = $_POST['due_date'];
                $task['completion'] = $_POST['completion'];
                $task['priority'] = $_POST['priority'];
                $task['duration'] = $_POST['duration'];
                break;
            }
        }
    }

    if (isset($_POST['deleteTask'])) {
        $tasks = array_filter($tasks, function ($task) {
            return $task['id'] !== $_POST['id'];
        });
    }

    file_put_contents($tasksFile, json_encode(array_values($tasks)));
    header('Location: logistic.php'); // Redirect to the same department page
    exit();
}

// Handle search query
$searchId = isset($_GET['search_id']) ? $_GET['search_id'] : '';

// Filter tasks if search ID is provided
if ($searchId) {
    $tasks = array_filter($tasks, function ($task) use ($searchId) {
        return stripos($task['id'], $searchId) !== false;
    });
}

// Export to Excel
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="tasks.xls"');
    header('Cache-Control: max-age=0');
    
    echo "ID\tTask\tAssigned\tStatus\tStart Date\tDue Date\tCompletion\tPriority\tDuration\n";
    
    foreach ($tasks as $task) {
        echo "{$task['id']}\t{$task['task']}\t{$task['owner']}\t{$task['status']}\t{$task['start_date']}\t{$task['due_date']}\t{$task['completion']}\t{$task['priority']}\t{$task['duration']}\n";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Logistic Department</title> <!-- Change title for each department -->
    <link rel="stylesheet" href="style_index.css">
    <link rel="icon" type="image/x-icon" href="Superpack-Enterprise-Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Existing styles */
        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
            width: 300px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="container">
        <h1 class="my-4">Logistic Department</h1> <!-- Change header for each department -->

        <!-- Search Bar and Export/Print Options -->
        <div class="search-bar">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search_id" placeholder="Search by ID" value="<?php echo htmlspecialchars($searchId); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="?export=excel" class="btn btn-success ml-2">Export to Excel</a>
                    </div>
                </div>
            </form>
        </div>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addTaskModal">Add Task</button>
        <button class="btn btn-secondary mb-3" onclick="window.print()">Print</button>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Assigned</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>Due Date</th>
                    <th>Completion</th>
                    <th>Priority</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                <?php
                // Determine classes for completion and status
                $completionClass = 'completion-bar low';
                if ($task['completion'] > 50) {
                    $completionClass = 'completion-bar medium';
                }
                if ($task['completion'] > 80) {
                    $completionClass = 'completion-bar high';
                }

                $statusClass = 'status-not-started';
                if ($task['status'] === 'In Progress') {
                    $statusClass = 'status-in-progress';
                }
                if ($task['status'] === 'Completed') {
                    $statusClass = 'status-completed';
                }
                ?>
                <tr>
                    <td><?php echo $task['id']; ?></td>
                    <td><?php echo $task['task']; ?></td>
                    <td><?php echo $task['owner']; ?></td> <!-- Updated to 'Assigned' -->
                    <td class="<?php echo $statusClass; ?>"><?php echo $task['status']; ?></td>
                    <td><?php echo $task['start_date']; ?></td>
                    <td><?php echo $task['due_date']; ?></td>
                    <td>
                        <div class="<?php echo $completionClass; ?>" style="width: <?php echo $task['completion']; ?>%;"></div>
                        <?php echo $task['completion']; ?>%
                    </td>
                    <td><?php echo $task['priority']; ?></td>
                    <td><?php echo $task['duration']; ?> days</td>
                    <td>
                        <!-- Actions -->
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editTaskModal" data-id="<?php echo $task['id']; ?>">Edit</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            <button type="submit" name="deleteTask" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="task">Task</label>
                            <input type="text" class="form-control" id="task" name="task" required>
                        </div>
                        <div class="form-group">
                            <label for="owner">Assigned</label> <!-- Changed to 'Assigned' -->
                            <input type="text" class="form-control" id="owner" name="owner" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Not Started">Not Started</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>
                        <div class="form-group">
                            <label for="completion">Completion (%)</label>
                            <input type="number" class="form-control" id="completion" name="completion" min="0" max="100" required>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration (Days)</label>
                            <input type="number" class="form-control" id="duration" name="duration" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addTask" class="btn btn-primary">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <!-- Same fields as Add Task Modal -->
                        <div class="form-group">
                            <label for="edit_task">Task</label>
                            <input type="text" class="form-control" id="edit_task" name="task" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_owner">Assigned</label> <!-- Changed to 'Assigned' -->
                            <input type="text" class="form-control" id="edit_owner" name="owner" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="Not Started">Not Started</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_start_date">Start Date</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_due_date">Due Date</label>
                            <input type="date" class="form-control" id="edit_due_date" name="due_date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_completion">Completion (%)</label>
                            <input type="number" class="form-control" id="edit_completion" name="completion" min="0" max="100" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_priority">Priority</label>
                            <select class="form-control" id="edit_priority" name="priority" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_duration">Duration (Days)</label>
                            <input type="number" class="form-control" id="edit_duration" name="duration" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="editTask" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editTaskModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var taskId = button.data('id');
            var modal = $(this);
            var row = button.closest('tr');
            modal.find('#edit_id').val(taskId);
            modal.find('#edit_task').val(row.find('td:eq(1)').text());
            modal.find('#edit_owner').val(row.find('td:eq(2)').text());
            modal.find('#edit_status').val(row.find('td:eq(3)').text());
            modal.find('#edit_start_date').val(row.find('td:eq(4)').text());
            modal.find('#edit_due_date').val(row.find('td:eq(5)').text());
            modal.find('#edit_completion').val(row.find('td:eq(6)').find('.completion-bar').attr('style').match(/\d+/)[0]);
            modal.find('#edit_priority').val(row.find('td:eq(7)').text());
            modal.find('#edit_duration').val(row.find('td:eq(8)').text().split(' ')[0]);
        });
    </script>
</body>
</html>
