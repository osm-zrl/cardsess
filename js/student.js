function togglescancard() {
    let scanstudent = document.getElementById('scanstudent');
    if (scanstudent.classList.contains('hidden')) {
        scanstudent.classList.remove('hidden');
        scanstudent.classList.add('displayed');
        black_layer.style.right = 0
    } else {
        scanstudent.classList.add('hidden');
        scanstudent.classList.remove('displayed');
        black_layer.style.right = '-100vw'
    }
}

function readcard() {
    readingCard = setInterval(() => {
        $.ajax({
            url: 'http://127.0.0.1:8043/read',
            type: 'GET',
            crossDomain: true,
            success: function (response) {
                if (response.split(':')[0] == 'SUCCESS') {
                    card_uid = response.split(':')[1].split(',')[0].trim()

                    document.getElementById('card_uid').value = card_uid

                    clearInterval(readingCard)
                    let cardStudID = response.split(':')[1].split(',')[1].trim()

                    if (cardStudID != '') {
                        addMSG('warning','WARNING: this card got a <strong> student id </strong> in it!'+cardStudID)
                    }else{
                        addMSG('success',"card's id scanned successfully")
                    }
                    scanCardBtn.innerHTML = 'scan'

                }
                else if(response.trim() == "ERROR: arduino not connected!"){
                    addMSG('warning','scanner not connected to RFIDSER')
                    scanCardBtn.innerHTML = "scan"
                    clearInterval(readingCard)
                }
                else if(response.trim() == 'ERROR: card not detected'){
                    console.log(response)
                    
                }else{
                    addMSG('danger','something went wrong!')
                    scanCardBtn.innerHTML = "scan"
                    clearInterval(readingCard)
                }
            },
            error: function (xhr, status, error) {
                console.log('Error:', error);
                addMSG('danger','failed to connect to rfidser server')
                scanCardBtn.innerHTML = "scan"
                clearInterval(readingCard)
            }
        });
    }, 1000)
}