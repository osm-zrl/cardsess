<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('head.php');
    require('dbconfig.php'); ?>
    <title>Presence Log</title>

    <style>
        .filter {
            display: flex;
            align-items: center;
            width: 80%;
            gap: 2rem;
        }

        .filter select,
        .filter input {
            width: 49.5%;
        }
    </style>
</head>

<body>
    <aside>
        <?php include('aside.php'); ?>
    </aside>

    <main>

        <div class="top-main">
            <div class="title">
                <h2>Presence Log</h2>
                <h5>All time Card Scans</h5>
            </div>
        </div>


        </div>
        <div class="filter">
            <input type='date' id="date" name="date">
            <select name="time" id="time">
                <option selected value="">Select Period</option>
                <option value="1">08:30 - 11:00</option>
                <option value="2">11:00 - 13:30</option>
                <option value="3">13:30 - 15:00</option>
                <option value="4">15:00 - 18:30</option>
            </select>

        </div>

        <!--Table--->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col">CARD'S ID</th>
                    <th class="col">STUDENT'S ID</th>
                    <th class="col">STUDENT'S FULLNAME</th>
                    <th class="col">TIMESTAMP</th>
                </tr>
            </thead>
            <tbody id="logTable">

            </tbody>
        </table>
    </main>
    <?php require('footer.php') ?>

    <script>
        $.ajax({
            url: 'php/search_log.php',
            type: 'POST',
            success: function (response) {
                console.log(response.length)
                if (response.length == 0) {
                    $('#logTable').html(
                        `<tr>
                                <td colspan="4">No Log Data Detected</td>
                                </tr>`
                    )
                } else {
                    $('#logTable').html("")
                    response.forEach(e => {
                        $('#logTable').append(
                            `<tr>
                                <td>`+ e.card_id + `</td>
                                <td>`+ e.student_id + `</td>
                                <td>`+ e.nom_complete + `</td>
                                <td>`+ e.scan_time + `</td>
                            </tr>`
                        )
                    })
                }
            },
            error: function (xhr, status, error) {

            }
        });
        $(document).ready(function () {

            $('#date, #time').on('change', function () {
                var dateFilter = $('#date').val();
                var timeFilter = $('#time').val();
                
                $.ajax({
                    url: 'php/search_log.php',
                    type: 'POST',
                    data: { 'date': dateFilter, 'time': timeFilter },
                    success: function (response) {
                        console.log(response)
                        
                        if (response.length == 0) {
                            $('#logTable').html(
                                `<tr>
                                <td colspan="4">No Log Data Detected</td>
                                </tr>`
                            )
                        } else {
                            $('#logTable').html("")
                            response.forEach(e => {
                                $('#logTable').append(
                                    `<tr>
                                <td>`+ e.card_id + `</td>
                                <td>`+ e.student_id + `</td>
                                <td>`+ e.nom_complete + `</td>
                                <td>`+ e.scan_time + `</td>
                            </tr>`
                                )
                            })
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });

            });
        });
    </script>

</body>

</html>