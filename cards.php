<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');
    require('dbconfig.php');?>
    <title>manage cards</title>
</head>
<body>
    <?php require('aside.php');?>
    <!-- top main title + statics cards  -->
    <main>
        <div class="top-main">
            <div class="title">
                <h2>MANAGE CARDS</h2>
                <h5>Add and desactivate cards from here</h5>
            </div>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-id-card"></i>
                    <div class="card-text">
                        <span>280</span>
                        <p>Cards</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-check"></i>
                    <div class="card-text">
                        <span>228</span>
                        <p>Active Cards</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-xmark"></i>
                    <div class="card-text">
                        <span>52</span>
                        <p>Blocked Cards</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="link-div">
            <a href="#" onclick="toggleScan()" id="addstudentbtn">Add Card</a>
        </div>
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Card UID</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div id="addstudent" class="form hidden">
            <div class="blocktitle">
                <h3> add card</h3>
                <i class="fa-solid fa-xmark" onclick="toggleAddStudent()"></i>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/script.js"></script>
</body>
</html>