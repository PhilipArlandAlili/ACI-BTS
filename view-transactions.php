<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/head.php' ?>
    <title>ACI-BT | View Transactions</title>
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <?php include 'includes/header.php' ?>
    </header>

    <aside id="sidebar" class="sidebar">
        <?php include 'includes/sidebar.php' ?>
    </aside>

    <main id="main" class="main">
        <a href="dashboard.php" class="navigation d-flex align-items-center py-3 mx-2">
            <i class="bx bxs-caret-left-square fs-2 "></i>
            <span class="fs-3 fw-semibold ">Back</span>
        </a>

        <section class="section">
            <div class="row fs-4">
                <div class="col-lg-12">
                    <div class="card" id="transactions">
                        <div class="card-body">
                            <h5 class="card-title fs-4">Transaction Table</h5>
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th class="fs-5">Transacted by</th>
                                        <th class="fs-5">Document Name</th>
                                        <th class="fs-5">Client Name</th>
                                        <th class="fs-5">Created At</th>
                                        <th class="fs-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require 'includes/db.php';
                                    $sql = "SELECT t.id, a.username AS transact_by, dt.doc_name, 
                                                CASE 
                                                    WHEN dt.id = 1 THEN CONCAT(COALESCE(bc.first_name, ''), ' ', COALESCE(bc.middle_name, ''), ' ', COALESCE(bc.last_name, ''))
                                                ELSE 'Unknown' 
                                                    END AS full_name, t.client_trans_id, t.created_at
                                                FROM transactions t
                                                    INNER JOIN admin a ON t.transact_by = a.id
                                                    INNER JOIN doctype dt ON t.doc_id = dt.id
                                                    LEFT JOIN barangay_clearance bc ON t.client_trans_id = bc.id AND dt.id = 1";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr class='fs-5'>";
                                            // echo "<td>" . $row["id"] . "</td>";
                                            echo "<td>" . $row["transact_by"] . "</td>";
                                            echo "<td>" . $row["doc_name"] . "</td>";
                                            echo "<td>" . $row["full_name"] . "</td>";
                                            // echo "<td>" . $row["client_trans_id"] . "</td>";
                                            echo "<td>" . $row["created_at"] . "</td>";
                                            echo "<td><a href='show_client_trans.php?id=" . $row["client_trans_id"] . "&doc_name=" . str_replace(" ", "_", $row["doc_name"]) . "'><button type='submit' class='btn btn-primary'>VIEW</button></a></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'><center>No transactions found</center></td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer">
        <?php include 'includes/footer.php' ?>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>