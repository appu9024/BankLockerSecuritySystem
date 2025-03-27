<?php include 'adminheader.php'; ?>
<html>
<?php require_once('connection.php'); ?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <h4 class="page-title">View All Logs</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Email ID</th>
                                    <th>Time</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM `in_logs`";
                                $result = mysqli_query($link, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $time = date('Y-m-d H:i:s', $row['time']);
                                    echo "<tr>
                                        <td>{$row['fin_id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$time}</td>
                                        <td>
                                            <div class='btn-group'>
                                                <button data-toggle='dropdown' class='btn btn-info dropdown-toggle'>Options <span class='caret'></span></button>
                                                <ul class='dropdown-menu'>
                                                    <li><a href='delete_log.php?id={$row['id']}' onclick='return confirm('Are you sure you want to delete this log?'')'>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
</body>
</html>
