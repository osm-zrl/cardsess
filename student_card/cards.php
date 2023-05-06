<?php
// Include the database connection file
require_once "connection.php";

// Execute a SQL query to count the number of students
$sql_students = "SELECT COUNT(*) FROM student";
$result_students = $conn->query($sql_students);

// Execute a SQL query to count the number of classes
$sql_classes = "SELECT COUNT(*) FROM classe";
$result_classes = $conn->query($sql_classes);

// Execute a SQL query to count the number of cards
$sql_cards = "SELECT COUNT(*) FROM cards";
$result_cards = $conn->query($sql_cards);

// Check if the queries were successful
if ($result_students && $result_classes) {
    // Get the number of rows returned by the queries
    $row_students = $result_students->fetch_row();
    $num_students = $row_students[0];

    $row_classes = $result_classes->fetch_row();
    $num_classes = $row_classes[0];

    $row_cards = $result_cards->fetch_row();
    $num_cards = $row_cards[0];
} else {
    echo "Error: " . $conn->error;
}

$sql_cards = "SELECT id, card_uid FROM cards";
$result_cards = $conn->query($sql_cards);

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Execute a SQL query to delete the card with the given "id" value
  $sql = "DELETE FROM cards WHERE id = '$id'";
  $result = $conn->query($sql);

  // Check if the deletion was successful
  if ($result) {
    // Redirect the browser to the same page to reload the list of cards
    header('Location: cards.php');
    exit();
  } else {
    // If the deletion failed, show an error message
    echo "Failed to delete the card";
  }
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  $id = '';
}

// Get the card data from the database
$sql_cards = "SELECT * FROM cards";
$result_cards = $conn->query($sql_cards);


// Check if the form was submitted to insert a new card's information
if (isset($_POST['card_uid'])) {
  // Get the values from the form
  $card_uid = $_POST['card_uid'];

  // Prepare a SQL query to insert the new card into the database
  $sql = "INSERT INTO cards (card_uid) 
          VALUES ('$card_uid')";

  // Execute the SQL query
  if ($conn->query($sql) === TRUE) {
    // Redirect the user back to the cards page
    header("Location: cards.php");
    exit();
  } else {
    // Display an error message on the same page
    $error_message = "Error: " . $sql . "<br>" . $conn->error;
  }
}

if (isset($_POST['update_uid'])) {
  $id = $_POST['id'];
  $new_uid = $_POST['uid'];


  // Prepare a SQL query to update the card's UID in the database
  $sql = "UPDATE cards SET card_uid='$new_uid' WHERE id='$id'";

  // Execute the SQL query
  if ($conn->query($sql) === TRUE) {
    // Redirect the user back to the cards page
    header("Location: cards.php");
    exit();
  } else {
    // Display an error message on the same page
    $error_message = "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/students.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <aside class="sidebar">
        <div class="side-logo">
            <h1>Educia.</h1>
        </div>
        <div class="principal-menu">
            <a href="main.php">
                <i class="fa-solid fa-table-columns"></i>
                Dashboard
            </a>
            <a href="students.php">
                <i class="fa-solid fa-users"></i>
                Students
            </a>
            <a href="#" class="active">
                <i class="fa-solid fa-id-card"></i>
                Cards
            </a>
            <a href="#" class="active" id="entry">
                <i class="fa-solid fa-door-closed"></i>
                entry/exit
                <div class="live">
                    <i class="fa-solid fa-wifi"></i>
                </div>  
            </a>
        </div>
        <div class="seconde-menu">
            <a href="link.php">
                <i class="fa-solid fa-link"></i>
                Link card/student
            </a>
            <a href="#">
                <i class="fa-solid fa-list"></i>
                Classes
            </a>
            <a href="#">
                
            </a>
            <a href="#">
                
            </a>
        </div>
        <div class="bottom-menu">
            <a href="#">
                <i class="fa-solid fa-clock-rotate-left"></i>
                History
            </a>
        </div>
    </aside>
    <main>
    <div class="top-dashboard">
      <div class="text">
        <h2>Cards Place</h2>
        <h5>Here’s you can see all the Cards</h5>
      </div>
      <div class="cards">
        <div class="card">
        <i class="fa-solid fa-id-card"></i>
          <div class="card-text">
            <span id='cards'><?php echo $num_cards; ?></span>
            <p>Card</p>
          </div>
        </div>
        <div class="card">
          <i class="fa-solid fa-address-book"></i>
          <div class="card-text">
            <span id="pass"></span>
            <p>pass/day</p>
          </div>
        </div>
        <div class="card">
          <i class="fa-solid fa-chalkboard-user"></i>
          <div class="card-text">
            <span id="class">%</span>
            <p>pass/year</p>
          </div>
        </div>
      </div>
    </div>
    <div class="addcard">
      <a href="#" onclick="toggleAddCard()" id="addcardbtn">Add Card</a>
    </div>
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
      <?php
// Loop through the result set and display each card in a table row
while ($cards = $result_cards->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $cards['id'] . "</td>";
  echo "<td>" . $cards['card_uid'] . "</td>";
  echo '<td><a href="#" onclick="toggleEditCard(' . $cards["id"] . ')"><i class="fa-solid fa-pen-to-square" id="icontable"></i></a></td>';
  echo '<td><a href="cards.php?id=' . $cards["id"] . '" onclick="return confirm(\'Are you sure you want to delete this card?\')"><i class="fa-solid fa-trash" id="icontable"></i></a></td>';
  echo "</tr>";            
}
                ?>
      </tbody>
    </table>
    <div id="addcard" class="hidden">
      <div class="blocktitle">
        <h3> Add UID Card</h3>
        <i class="fa-solid fa-xmark" onclick="toggleAddCard()"></i>
      </div>
      <?php if (isset($error_message)) { ?>
  <div class="error"><?php echo $error_message; ?></div>
<?php } ?>
<form id="addcardform" action="cards.php" method="post">
        <div class="information">
          <div class="cef">
            <input type="number" id="card_uid" name="card_uid" placeholder="Enter UID">
          </div>
          <button type="submit">Add Card</button>
        </div>
      </form>
    </div>
    <div id="editcard" class="hidden">
  <div class="blocktitle">
    <h3>Edit Card</h3>
    <i class="fa-solid fa-xmark" onclick="toggleEditCard()"></i>
  </div>
  <form id="edit-card-form" action="" method="post">
  <div class="information">
    <div class="uid">
      <input type="number" name="id" value="" readonly>
      <input type="number" id="uid" name="uid" placeholder="Enter UID" required>
    </div>
    <button type="submit" name="update_uid">Save Changes</button>
  </div>
</form>
</div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
</body>
</html>


<script>
  
  function toggleAddCard() {
    let addCard = document.getElementById('addcard');
    if (addCard.classList.contains('hidden')) {
      addCard.classList.remove('hidden');
    } else {
      addCard.classList.add('hidden');
    }
    }

    function toggleEditCard() {
  let editcard = document.getElementById('editcard');
  if (editcard.classList.contains('hidden')) {
    editcard.classList.remove('hidden');
  } else {
    editcard.classList.add('hidden');
  }
  }


  function toggleEditCard(cardId) {
  var editcard = document.getElementById("editcard");
  var cardUidInput = editcard.querySelector('input[name="uid"]');
  var cardIdInput = editcard.querySelector('input[name="id"]');

  if (editcard.classList.contains("hidden")) {
    editcard.classList.remove("hidden");

    // Set the value of the card ID input field
    cardIdInput.value = cardId;

    // Set the focus to the card UID input field
    cardUidInput.focus();
  } else {
    editcard.classList.add("hidden");
  }
}


</script>

