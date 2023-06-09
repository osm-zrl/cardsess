var readingCard,card_uid;
var cardScanMsg = document.getElementById('cardScanMsg')
var cardScanLoader = document.getElementById('cardScanLoader')

function togglescancard() {
    clearInterval(readingCard)
    let scanstudent = document.getElementById('scanstudent');
    if (scanstudent.classList.contains('hidden')) {
        scanstudent.classList.remove('hidden');
        scanstudent.classList.add('displayed');
        black_layer.style.right = 0
        cardScanLoader.style.display = ''
        if (readingCard == undefined){
            readcard()
        }
    } else {
        scanstudent.classList.add('hidden');
        scanstudent.classList.remove('displayed');
        black_layer.style.right = '-100vw'
        clearInterval(readingCard)
        readingCard = undefined
    }

    
    
}

function readcard() {
    console.log('started')
    cardScanMsg.innerHTML=''
    readingCard = setInterval(() => {
        $.ajax({
            url: 'http://127.0.0.1:8043/read',
            type: 'GET',
            crossDomain: true,
            success: function (response) {
                
                if (response.split(':')[0] == 'SUCCESS') {
                    card_uid = response.split(':')[1].split(',')[0].trim()


                    clearInterval(readingCard)
                    readingCard= undefined
                    let cardStudID = response.split(':')[1].split(',')[1].trim()

                    cardScanLoader.style.display = 'none'
                    cardScanMsg.innerHTML = ('success',"card's id scanned successfully")
                    console.log(cardStudID)
                    $.ajax({
                        url:'php/checkIfStuExist.php',
                        type:'POST',
                        data:{
                            'student_id': cardStudID,
                        },
                        success:function (response) {
                            if (response.trim()=='true'){
                                window.location.assign('student_info.php?student_id='+cardStudID)
                            }else{
                                cardScanMsg.innerHTML =('unknown student ID')
                            }
                        },
                        error:function (err) {
                            console.log(err)
                        }

                    });
                    

                }
                else if(response.trim() == "ERROR: arduino not connected!"){
                    cardScanLoader.style.display = 'none'
                    cardScanMsg.innerHTML =('warning','scanner not connected to RFIDSER')
                    clearInterval(readingCard)
                    readingCard= undefined
                }
                else if(response.trim() == 'ERROR: card not detected'){
                    console.log(response)
                    
                }else{
                    cardScanLoader.style.display = 'none'
                    cardScanMsg.innerHTML =('danger','something went wrong!')
                    clearInterval(readingCard)
                    readingCard= undefined
                }
            },
            error: function (xhr, status, error) {
                console.log('Error:', error);
                cardScanLoader.style.display = 'none'
                cardScanMsg.innerHTML =('danger','failed to connect to rfidser server')
                clearInterval(readingCard)
                readingCard= undefined
            }
        });
    }, 1000)
}