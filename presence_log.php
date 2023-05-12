<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');
    require('dbconfig.php');?>
    <title>main</title>
</head>
<body>
    <?php require('aside.php');?>
    <!-- top main title + statics cards  -->
    <main>
        <div class="top-main">
            <div class="title">
                <h2>Your title here</h2>
                <h5>Your description here</h5>
            </div>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-users"></i>
                    <div class="card-text">
                        <span>320</span>
                        <p>Students</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-id-card"></i>
                    <div class="card-text">
                        <span>280</span>
                        <p>Cards</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-chalkboard"></i>
                    <div class="card-text">
                        <span>15</span>
                        <p>Classes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="link-div">
            <a href="#" onclick="toggleAddStudent()" id="addstudentbtn">Add Student</a>
        </div> -->
        
        <!-- ========================================================================= -->






        <!-- ========================================================================== -->

        <table>
            <thead>
                <tr>
                    <th class="col"> col 1 </th>
                    <th class="col"> col 2 </th>
                    <th class="col"> col 3 </th>
                    <th class="col"> col 4 </th>
                    <th class="col"> col 5 </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> item 1 </td>
                    <td> item 2 </td>
                    <td> item 3 </td>
                    <td> item 4 </td>
                    <td> item 5 </td>
                </tr>
            </tbody>
        </table>
        
        
        
    </main>
    <? require('footer.php')?>
</body>
</html>