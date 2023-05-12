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

                <h2>LIVE ENTRY</h2>

                <h5>Real time tracking of card scans</h5>

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
                        <td>` + data[i].card_id + `</td>
                        <td>` + data[i].student_id + `</td>
                        <td>` + data[i].nom_complete + `</td>
                        <td>` + data[i].scan_time + `</td>
                        </tr>`;
                        Tbody.innerHTML += row; // Add the new row to the top of the table

                        lastID = data[0].scan_id
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
                        console.log(data)
                        $.each(data, function (index, row) {
                            if (row.scan_id > lastID) {
                                let ro = `<tr>
                        <td>` + row.card_id + `</td>
                        <td>` + row.student_id + `</td>
                        <td>` + row.nom_complete + `</td>
                        <td>` + row.scan_time + `</td>
                        </tr>`;
                                Tbody.innerHTML = ro + Tbody.innerHTML;
                                lastID = row.scan_id;
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