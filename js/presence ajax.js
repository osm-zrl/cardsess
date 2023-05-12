const Tbody = document.getElementById('logTable');

var lastID;

function getall() {

    $.ajax({

        url: 'logData.php',

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

            url: 'logData.php',

            type: 'GET',

            dataType: 'json',

            data: {

                lastID: lastID

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