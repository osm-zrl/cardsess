<!DOCTYPE html>

<html lang="en">

<head>

    
    <?php require('head.php')?>
    <title>Document</title>

    
    <link rel="stylesheet" href="presence.css">

</head>

<body>




    <aside>

        
        <?php require('aside.php') ?>

        
    </aside>

    

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

        <table>

            <thead>

                <tr>

                    <th class="col"> Card UID </th>

                    <th class="col"> CEF </th>

                    <th class="col"> Nom Complet </th>

                    <th class="col"> Date </th>




                    </tr>

                </thead>

            <tbody id="logTable">

                

                </tbody>

            </table>

        </main>





    <?php require('footer.php') ?>
    <script>
        const Tbody = document.getElementById('logTable');
        var lastID;
        function getall() {
            $.ajax({
                url: 'php/logData.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    for (let i = 0; i < data.length; i++) {
                        let row = `<tr>
                        <td>` + data[i].cardUID + `</td>
                        <td>` + data[i].etuCEF + `</td>
                        <td>` + data[i].nom_complete + `</td>
                        <td>` + data[i].datetime + `</td>
                        </tr>`;
                        Tbody.innerHTML += row; // Add the new row to the top of the table

                        lastID = data[0].logID
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Error: ' + textStatus);
                }
            });
        }
        getall();


        setInterval(function () {
            if (!(lastID == undefined)) {
                $.ajax({
                    url: 'php/logData.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        lastID: lastID,
                    },
                    success: function (data) {
                        $.each(data, function (index, row) {
                            if (row.logID > lastID) {
                                let ro = `<tr>
                        <td>` + row.cardUID + `</td>
                        <td>` + row.etuCEF + `</td>
                        <td>` + row.nom_complete + `</td>
                        <td>` + row.datetime + `</td>
                        </tr>`;
                                Tbody.innerHTML = ro + Tbody.innerHTML;
                                lastID = row.logID;
                            }
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Error: ' + textStatus);
                    }
                });
            } else {
                getall()
            }

        }, 250);

    </script>



</body>

</html>