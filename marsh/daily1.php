<?php
$sid = $_GET['sid'];
?>
<div class="main-content">

    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="breadcrumb">
                <h1 class="mr-2"><?php echo $headingname; ?></h1>
                <ul>
                    <li><a href="">Dashboard</a></li>
                    <li>Home</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4 col-sm-12"><input type="text" id="cardSearch" class="form-control form-control-lg"
                placeholder="Search Checks..."></div>
    </div>




    <div class="mb-4">
        <div class="row">
            <div class="col-md-8"></div>

        </div>

    </div>

    <div class="separator-breadcrumb border-top"></div>


    <!-- No results message -->
    <div id="noResults" class="alert alert-warning" style="display: none;">
        No cards match your search.
    </div>
    <div class="row" id="cardsContainer">
        <!-- ICON BG-->
        <?php
        $gh = mysqli_query($con, "select * from dailychecks where sid='$sid'and status='third'");
        while ($row = mysqli_fetch_array($gh)) {

           
            
            ?>
                <div class="col-lg-3 col-md-6 col-sm-6 card-item" style="height:300px;">
                    <?php
                    if(!empty($row['url'])){
                         ?>
                          <a href="admin.php?id=viewdaily&spid=<?php echo $row['spid']; ?>">
                        <?php
                    }
                    else{
                        ?>
                         <a href="admin.php?id=viewdaily&sid=<?php echo $row['id']; ?>">
                        <?php
                    }

                    ?>
                   
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="height:230px;">
                            <div class="card-body  text-center "><i class="fa fa-list"
                                    style="font-size:50px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0 card-title"><?php echo $row['name']; ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        <?php }
        ?>




    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('cardSearch');
        const cardsContainer = document.getElementById('cardsContainer');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();
            const cards = document.querySelectorAll('.card-item');
            let hasMatches = false;

            cards.forEach(card => {
                // Search in the card title specifically
                const cardTitle = card.querySelector('.card-title').textContent.toLowerCase();
                const isMatch = searchTerm === '' || cardTitle.includes(searchTerm);

                // Show/hide the parent column div to maintain grid layout
                card.style.display = isMatch ? 'block' : 'none';
                if (isMatch) hasMatches = true;
            });

            // Show message if no results
            const noResultsMsg = document.getElementById('noResults');
            if (noResultsMsg) {
                noResultsMsg.style.display = hasMatches || searchTerm === '' ? 'none' : 'block';
            }
        });
    });
</script>