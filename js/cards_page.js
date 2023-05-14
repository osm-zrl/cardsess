/* var readingCardInterval;
var cardWstate_is

var addstudentDiv_MSG = document.getElementById('addstudentMSG')
var subBTN = document.getElementById('submitBTN')

var student_id,card_uid

function addMSG(text,color){
    addstudentDiv_MSG.innerHTML = 
    `<div class="alert alert-`+color+` alert-dismissible fade show" role="alert">
    `+text+`
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    
    </div>`
}


function readcard() {
    readingCardInterval = setInterval(() => {
        $.ajax({
            url: 'http://127.0.0.1:8043/read',
            type: 'GET',
            crossDomain: true,
            success: function (response) {
                if (response.split(':')[0] == 'SUCCESS') {
                    console.log(response)
                    card_uid = response.split(':')[1].split(',')[0].trim()
                    student_id = response.split(':')[1].split(',')[1].trim()
                    clearInterval(readingCardInterval)
                    readingCardInterval = undefined
                    subBTN.innerHTML="submit"

                    if (student_id != ''){
                        addMSG('this card already registered for a student!','info')
                    }

                    if (confirm('do you wanna complete the process?')){
                        console.log('yes')
                    }
                }
                
            },
            error: function (xhr, status, error) {

                clearInterval(readingCardInterval)
                console.log('Error:', error);
                addMSG('failed to connect to RFIDSER','danger')
                subBTN.innerHTML="submit"
            }
        });
    }, 1000)
}

function scanCard(Btn){

   Btn.innerHTML = `<i style="font-size:1.3rem; color:white;" class="fa-solid fa-spinner i-spinners"></i>`
    
    if (readingCardInterval == undefined){
        clearInterval(readingCardInterval)
        readcard()
    }else{
        clearInterval(readingCardInterval)
        readingCardInterval = undefined
        subBTN.innerHTML = "submit"
    }
    

} */
var readingCard,card_uid,student_id,writingCard,carddataREG = false;
const addcard_popup_msgArea = document.getElementById('addcard_popup_msgArea')
const scanCardBtn = document.getElementById('scanCardBtn')
var Tbody = document.getElementById('cardsTableB')

scanCardBtn.addEventListener('click', () => {
    scanCardBtn.innerHTML = `
    <i style="font-size:1.3rem; color:white;" class="fa-solid fa-spinner i-spinners"></i>
            `
    if (readingCard == undefined) {
        readcard()
    } else {
        clearInterval(readingCard)
        readingCard = undefined
        scanCardBtn.innerHTML = 'scan'
    }


})
function addMSG(color, text) {
    addcard_popup_msgArea.innerHTML =  `
                        <div class="alert alert-`+color+` alert-dismissible fade show" style="width: 100%;" role="alert">
                        `+text+`
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>                
 `
}
addMSG('info','keep the card on the scanner')

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
                    if (response.split(':')[1].split(',')[1].trim() != '') {
                        addMSG('warning','WARNING: this card got a <strong> student id </strong> in it!')
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

function checkINFO(){
    student_id = document.getElementById('student_id').value
    $.ajax({
        url: 'php/cards_check.php',
        type: 'POST',
        crossDomain: true,
        data: {
            'student_id': student_id,
            'card_uid': card_uid,
        },
        success: function (response) {
            response = response.trim()
            
            switch(parseInt(response.trim())){
                case 0:
                    addMSG('warning','card already exist in database!')
                    document.getElementById('submitBTN').innerHTML = 'submit'
                    break
                case 1:
                    $("#exampleModal").modal('show');
                    document.getElementById('disableAndSubmitBtn').addEventListener('click',()=>{
                        disableCards(student_id)
                        $("#exampleModal").modal('hide');
                    })
                    document.getElementById('disableAndSubmitBtn').removeEventListener('click',()=>{})
                    break
                default:
                    regCard((card_uid+student_id),student_id)

            }

            


        },
        error: function (xhr, status, error) {
            console.log('Error:', error);
        }
    });
    
}

function disableCards(studID){
    $.ajax({
        url: 'php/disable_card.php',
        type: 'POST',
        crossDomain: true,
        data: {
            'student_id': student_id,
        },
        success: function (response) {
            response = response.trim()
            if (response == 'true'){
                regCard((card_uid+student_id),student_id)
            } // Do something with the response data

        },
        error: function (xhr, status, error) {
            console.log('Error:', error);
        }
    });
}

function regCard(card_id,stud_id){
    $.ajax({
        url: 'php/regcard.php',
        type: 'POST',
        crossDomain: true,
        data: {
            'card_id': card_id,
            'student_id': stud_id,
            
        },

        success: function (response) {
            response = response.trim()
            if (response=='true'){
                carddataREG = true
                writeCard(student_id)
            }
            

        },
        error: function (xhr, status, error) {
            console.log('Error:', error);
            document.getElementById('submitBTN').innerHTML = 'submit'
        }
    });
}

function submit(btn){
    
    clearInterval(writingCard)
    if (writingCard == undefined){
        btn.innerHTML = `<i style="font-size:1.3rem; color:white;" class="fa-solid fa-spinner i-spinners"></i>`
        checkINFO()
    }else if(carddataREG == true){

        DelDBCard((card_uid+student_id));
        addMSG('danger','card registration canceled.');
        document.getElementById('submitBTN').innerHTML = 'submit';

    }
    else{
        writeCard = undefined
        document.getElementById('submitBTN').innerHTML = 'submit'
    }
    
}
function writeCard(stud_id){
    writingCard = setInterval(()=>{
        $.ajax({
            url: 'http://127.0.0.1:8043/write',
            type: 'GET',
            crossDomain: true,
            data: {
                'cef': stud_id,
            },
            success: function (response) {
                response = response.trim()
                if (response == 'SUCCESS: CEF written to card.'){
                    addMSG('success','card added succesfully')
                    clearInterval(writingCard)
                    document.getElementById('submitBTN').innerHTML = 'submit'
                    writingCard = undefined
                }else{
                    addMSG('info','please set the card on Scanner to complete the process!')
                    console.log(response)
                }
                
            },
            error: function (xhr, status, error) {
                console.log('Error:', error);
                clearInterval(writingCard);
                addMSG('failed to connect to RFIDSER')
            }
        });
    },3000)
    
}
function DelDBCard(card_id){
    $.ajax({
        url: 'php/del_corrupt_card.php',
        type: 'POST',
        crossDomain: true,
        data: {
            'card_id': card_id,
            
        },
        success: function (response) {
            response = response.trim()
            if (response=='true'){
                console.log('card deleted from DB')
                carddataREG = false
            }
            else{
                console.log(response)
                DelDBCard(card_id)
            }
        },
        error: function (xhr, status, error) {
            console.log('Error:', error);
            document.getElementById('submitBTN').innerHTML = 'submit'
        }
    });
}
function getAllCardsTable(){
    $.ajax({
        url:'php/getCardsTable.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                let row = `<tr>
                <td>` + data[i].card_id + `</td>
                <td>` + data[i].student_id + `</td>
                <td>` + data[i].card_active + `</td>
                </tr>`;
                Tbody.innerHTML += row; // Add the new row to the top of the table

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + textStatus);
        }

    })
}
getAllCardsTable()