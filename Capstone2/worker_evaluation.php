<?php
$evaluationsFile = 'worker_evaluations.json'; // Change the file name as needed
$evaluations = json_decode(file_get_contents($evaluationsFile), true) ?? [];

// Handling form submissions for adding evaluations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addEvaluation'])) {
    $newEvaluation = [
        "id" => "EV" . rand(1000, 9999),
        "employee_id" => $_POST['employee_id'],
        "name" => $_POST['name'],
        "position" => $_POST['position'],
        "department" => $_POST['department'],
        "start_date" => $_POST['start_date'],
        "comments" => $_POST['comments'],
        "performance" => array_map('htmlspecialchars', $_POST)
    ];
    $evaluations[] = $newEvaluation;
    file_put_contents($evaluationsFile, json_encode($evaluations));
    header('Location: worker_evaluation.php'); // Fixed the filename
    exit();
}

// Handling delete action
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $evaluations = array_filter($evaluations, function($evaluation) use ($idToDelete) {
        return $evaluation['id'] !== $idToDelete;
    });
    file_put_contents($evaluationsFile, json_encode(array_values($evaluations)));
    header('Location: worker_evaluation.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Evaluations</title>
    <link rel="stylesheet" href="style_index.css">
    <link rel="icon" type="image/x-icon" href="Superpack-Enterprise-Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .carousel-item {
            height: auto;
            padding: 20px;
        }
        .carousel-item img {
            object-fit: cover;
            width: 100%;
        }
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            font-size: 24px;
            margin: 10px 0;
        }
        .rating input {
            display: none;
        }
        .rating label {
            color: #ddd;
            cursor: pointer;
        }
        .rating input:checked ~ label {
            color: gold;
        }
        .form-content {
            max-height: 500px;
            overflow-y: auto;
        }
        .carousel-control-prev, .carousel-control-next {
            width: 5%;
        }
        .form-group textarea {
            height: 150px;
        }
        .form-group input, .form-group select, .form-group textarea {
            font-size: 16px;
            padding: 10px;
        }
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: rgba(0,0,0,0.5);
            border-radius: 50%;
        }
        .print-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="container">
        <h1 class="my-4">Employee Evaluations</h1>

        <form class="form-inline mb-4" method="GET" action="">
            <input class="form-control mr-2" type="text" name="search_id" placeholder="Search by Employee ID" value="<?php echo htmlspecialchars($_GET['search_id'] ?? '', ENT_QUOTES); ?>">
            <input class="form-control mr-2" type="date" name="filter_date" placeholder="Filter by Date" value="<?php echo htmlspecialchars($_GET['filter_date'] ?? '', ENT_QUOTES); ?>">
            <button class="btn btn-primary" type="submit">Search & Filter</button>
        </form>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addEvaluationModal">Add Evaluation</button>
        <button class="btn btn-secondary print-btn" onclick="printTable()">Print</button>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Start Date</th>
                    <th>Comments</th>
                    <th>Performance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evaluations as $evaluation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($evaluation['id']); ?></td>
                    <td><?php echo htmlspecialchars($evaluation['employee_id']); ?></td>
                    <td><?php echo htmlspecialchars($evaluation['name']); ?></td>
                    <td><?php echo htmlspecialchars($evaluation['position']); ?></td>
                    <td><?php echo htmlspecialchars($evaluation['department']); ?></td>
                    <td><?php echo htmlspecialchars($evaluation['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($evaluation['comments']); ?></td>
                    <td>
                        <a href="view_performance.php?id=<?php echo urlencode($evaluation['id']); ?>" class="btn btn-info btn-sm">View</a>
                    </td>
                    <td>
                        <a href="edit_evaluation.php?id=<?php echo urlencode($evaluation['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?php echo urlencode($evaluation['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this evaluation?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Evaluation Modal -->
    <div class="modal fade" id="addEvaluationModal" tabindex="-1" role="dialog" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEvaluationModalLabel">Add Evaluation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body form-content">
                        <div id="evaluationCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Slide 1: Worker Information -->
                                <div class="carousel-item active">
                                    <div class="form-group">
                                        <label for="employee_id">Employee ID</label>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control" id="position" name="position" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select class="form-control" id="department" name="department" required>
                                            <option value="">Select Department</option>
                                            <option value="Sales">Sales</option>
                                            <option value="Purchasing">Purchasing</option>
                                            <option value="Purchase Development">Purchase Development</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="Logistics">Logistics</option>
                                            <option value="Accounting">Accounting</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                                    </div>
                                </div>

                                <!-- Slide 2: Performance Evaluation -->
                                <div class="carousel-item">
                                    <?php
                                    $questions = [
                                        "Quality of Work",
                                        "Punctuality",
                                        "Team Collaboration",
                                        "Problem Solving",
                                        "Communication Skills",
                                        "Leadership Skills",
                                        "Technical Skills",
                                        "Adaptability",
                                        "Creativity",
                                        "Overall Performance"
                                    ];
                                    shuffle($questions);
                                    foreach ($questions as $index => $question): ?>
                                    <div class="form-group">
                                        <label for="criteria_<?php echo $index + 1; ?>"><?php echo $question; ?></label>
                                        <div class="rating">
                                            <?php for ($j = 5; $j >= 1; $j--): ?>
                                            <input type="radio" id="criteria_<?php echo $index + 1; ?>_<?php echo $j; ?>" name="criteria_<?php echo $index + 1; ?>" value="<?php echo $j; ?>" required>
                                            <label for="criteria_<?php echo $index + 1; ?>_<?php echo $j; ?>">&#9733;</label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="form-group">
                                        <label for="comments">Additional Comments</label>
                                        <textarea class="form-control" id="comments" name="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#evaluationCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#evaluationCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addEvaluation" class="btn btn-primary">Save Evaluation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function printTable() {
            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Print Evaluation</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
            printWindow.document.write('</head><body >');
            printWindow.document.write(document.querySelector('table').outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    </script>
</body>
</html>
