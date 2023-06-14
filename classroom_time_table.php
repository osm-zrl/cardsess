<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('head.php');
    require('dbconfig.php'); ?>
    <title>main</title>
</head>

<body>
    <?php require('aside.php'); ?>
    <!-- top main title + statics cards  -->
    <main>
        <div class="top-main">
            <div class="title">
                <h2>devojj digiir 101</h2>
            </div>

        </div>
        <div class="link-div">
            <a href="#" id="addstudentbtn">Modify</a>
        </div>
        <!-- table -->
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th class="col">days</th>
                    <th class="col"> 08:30 - 10:50 </th>
                    <th class="col"> 10:50 - 13:30 </th>
                    <th class="col"> 13-30 - 15:50 </th>
                    <th class="col"> 16:10 - 18:30 </th>
                </tr>
            </thead>
            <tbody id="Tbody">
                <tr class="day_table">
                    <td>Monday</td>
                </tr>
                <tr class="day_table">
                    <td>Tuesday</td>
                </tr>
                <tr class="day_table">
                    <td>Wednesday</td>
                </tr>
                <tr class="day_table">
                    <td>Thursday</td>
                </tr>
                <tr class="day_table">
                    <td>Friday</td>
                </tr>
                <tr class="day_table">
                    <td>Saturday</td>
                </tr>

            </tbody>
        </table>

        <script>
            

            function getTimeTables() {
                $.ajax({
                    url: "php/time_table_api.php",
                    data: {
                        'class_id': 1,
                    },
                    beforeSend: function () {

                    }, success: function (response) {
                        console.log(response)
                        for (let i = 0; i < 6; i++) {
                            console.log('i = ' + i)
                            let days_schedule = []

                            response.forEach(function (el) {
                                if (el.day == i) {
                                    if (el.time_start == '08:30:00') {
                                        if (el.time_end == '10:50:00') {
                                            $($('.day_table')[i]).append(`<td time_start="` + el.time_start + `">` + el.module + `</td>`)


                                        } else if (el.time_end == '13:30:00') {
                                            $($('.day_table')[i]).append(`<td time_start="` + el.time_start + `" colspan='2'>` + el.module + `</td>`)
                                        }
                                    } else if (el.time_start == '10:50:00') {
                                        $($('.day_table')[i]).append(`<td time_start="` + el.time_start + `">` + el.module + `</td>`)
                                    } else if (el.time_start == '13:30:00') {
                                        if (el.time_end == '15:50:00') {
                                            $($('.day_table')[i]).append(`<td time_start="` + el.time_start + `">` + el.module + `</td>`)


                                        } else if (el.time_end == '18:30:00') {
                                            $($('.day_table')[i]).append(`<td time_start="` + el.time_start + `" colspan='2'>` + el.module + `</td>`)
                                        }
                                    } else if (el.time_start == '15:50:00') {
                                        $($('.day_table')[i]).append(`<td time_start="` + el.time_start + `">` + el.module + `</td>`)
                                    }
                                }
                            })
                            


                        }
                        $('.day_table').each(function () {
                            let element=this
                            if(element.children.length == 1){
                                $(element).append(`<td></td><td></td><td></td><td></td>`)
                            }
                        })
                    }, error: function (err) {
                        console.log(err)
                    }, complete: function () {

                    }
                })
            }
            $(document).ready(function () {
                getTimeTables()
            })
        </script>
    </main>
    <?php require('footer.php'); ?>
</body>

</html>