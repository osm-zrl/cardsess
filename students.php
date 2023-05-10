<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');
    require('dbconfig.php');?>
    <title>Students</title>
</head>
<body>
    <?php require('aside.php');?>
    <!-- top main title + statics cards  -->
    <main>
        <div class="top-main">
            <div class="title">
                <h2>Students Place</h2>
                <h5>Here you can see all the students</h5>
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
                    <i class="fa-solid fa-address-book"></i>
                    <div class="card-text">
                        <span>23</span>
                        <p>absent</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <div class="card-text">
                        <span>94%</span>
                        <p>attendance rate</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="link-div">
            <a href="#" onclick="toggleAddStudent()" id="addstudentbtn">Add Student</a>
        </div>
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th scope="col">cef</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">gender</th>
                    <th scope="col">Classe</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <!-- forms -->
        <div id="addstudent" class="form hidden">
            <div class="blocktitle">
                <h3> Add Student</h3>
                <i class="fa-solid fa-xmark" onclick="toggleAddStudent()"></i>
            </div>

            <form id="form" action="" method="post">
                <div class="information">
                    <div class="col">
                        <input type="number" id="cef" name="cef" placeholder="Enter CEF">
                    </div>
                    <div class="col">
                        <input type="text" id="firstname" name="firstname" placeholder="Enter first-name">
                        <input type="text" id="lastname" name="lastname" placeholder="Enter last-name ">
                    </div>
                    <div class="col">
                        <input type="date" name="birthday" id="birthday">
                        <select name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="classe" id="classe">
                            <option value="">Select Student Group</option>
                            <option value="1">Developpement digital 101</option>
                            <option value="2">Developpement digital 102</option>
                            <option value="3">gestion etreprise 101</option>
                            <option value="4">gestion etreprise 102</option>
                            <option value="5">infograpie</option>
                        </select>
                    </div>
                    <button type="submit">Add Student</button>
                </div>
            </form>
        </div>
    </main>
    <?php require('footer.php') ?>
</body>
</html>