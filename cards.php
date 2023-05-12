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
    </style>
</head>

<body>
    <?php require('aside.php'); ?>
    <!-- top main title + statics cards  -->
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
        <div id="addstudent" class="form hidden" style="gap:0.5rem!important; ">
            <div class="blocktitle">
                <h3> add card</h3>
                <i class="fa-solid fa-xmark" onclick="togglecard()"></i>
            </div>

            <label for="card_id">card id:</label>
            <div>
                <input style="border-radius:5px 0 0 5px;" disabled type="text">
                <button style="padding:0.7rem; border-radius:0 12px 12px 0;" onclick="scanCard(this)"
                    type="button"><i style="font-size:1.3rem; color:white;" class="fa-solid fa-spinner i-spinners"></i></button>
            </div>
            <label for="card_id">student id:</label>
            <select>
                <option selected hidden>select student</option>
            </select>


        </div>
        </div>
    </main>

    <script src="js/cards_page.js"></script>

    <?php require('footer.php') ?>
</body>

</html>