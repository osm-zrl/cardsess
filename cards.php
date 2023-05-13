
<?php
require('dbconfig.php');

// prepare the SQL statement to count the total number of classes
$count_classes = "SELECT COUNT(DISTINCT card_id) as total_cards FROM cards";

// execute the SQL statement to count the total number of classes and store the result
$count_result = $conn->query($count_classes);
$count_row = $count_result->fetch_assoc();
$total_cards = $count_row['total_cards'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('head.php');
    require('dbconfig.php'); ?>
    <title>manage cards</title>
    <style>
        @keyframes spin{
            from {
                transform: rotate(0deg);
            }

            to{
                transform: rotate(360deg);
            }
        }
        .i-spinners {
            animation-name: spin;
            animation-duration:1s;
            animation-iteration-count: infinite;
            transition: 300ms;
        }
        #cardWState{
            height:20px;
            background-color: honeydew;
        }
    </style>
</head>

<body>
    <?php require('aside.php'); ?>
    <!-- top main title + statics cards -->
    <main>
        <div id="black_layer" style="right:-100vw;"></div>
        <div class="top-main">
            <div class="title">
                <h2>MANAGE CARDS</h2>
                <h5>Add and desactivate cards from here</h5>
            </div>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-id-card"></i>
                    <div class="card-text">
                        <span><?php echo $total_cards; ?></span>
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
            <a href="#" onclick="togglecard()" id="addstudentbtn">Add Card</a>
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
                <i class="fa-solid fa-xmark" onclick="togglecard()"></i>
            </div>

        
        <div id="cardWState">
                connecting to scanner
                scanning card
                checking database
                writing into card
                submiting into database
        </div>

        <div style="box-sizing:border-box;">
            <label for="">student id:</label>
            <select>
                <option selected hidden>select student</option>
                <?php 
                    $sql = "SELECT student_id, concat(first_name,' ',last_name) as full_name FROM student";
                    $res = $conn -> query($sql);
                    while ($row = $res->fetch_assoc()){
                    
                ?>
                <option value="<?php echo $row['student_id']?>"><?php echo $row['student_id'] ,'_',$row['full_name'] ?> </option>
                <?php
                    }
                ?>
            </select>
            <button onclick="scanCard(this)" class="d-block mx-auto" type = "button">SUBMIT</button>
        </div>
        <!-- 
                connecting to scanner
                scanning card
                checking database
                writing into card
                submiting into database

         -->



        </div>
        </div>
    </main>

    <script src="js/cards_page.js"></script>

    <?php require('footer.php') ?>
</body>

</html>