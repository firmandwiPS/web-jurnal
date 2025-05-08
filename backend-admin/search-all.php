<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Silakan login terlebih dahulu');
            document.location.href = 'login.php';
          </script>";
    exit;
}

$title = 'Search All Data';
include 'layout/header.php'; 

// Include the database connection (adjust the path if needed)
include 'config/database.php'; // Assuming 'config/database.php' contains the DB connection code.

?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Search Form -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Cari Semua Data</h3>
                        </div>
                        <div class="card-body">
                            <!-- Search Input Field with the Cari Button -->
                            <form method="GET" action="search-handler.php">
                                <div class="input-group mb-3">
                                    <input type="text" name="keyword" id="search-input" class="form-control" placeholder="Cari dengan kata kunci..." required>
                                    <div class="input-group-append">
                                        <button type="submit" name="search" class="btn btn-primary ml-2">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results Section -->
            <div id="search-results"></div>
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include 'layout/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Function to search data via AJAX
function searchData() {
    let keyword = $('#search-input').val();
    
    if (keyword === "") {
        $('#search-results').html(""); // Clear results if input is empty
        return;
    }

    $.ajax({
        url: 'search-handler.php',
        type: 'GET',
        data: { keyword: keyword },
        success: function(response) {
            $('#search-results').html(response); // Display results in #search-results
        }
    });
}
</script>
