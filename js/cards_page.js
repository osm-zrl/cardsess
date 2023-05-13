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
var readingCard;
const addcard_popup_msgArea = document.getElementById('addcard_popup_msgArea')
const scanCardBtn = document.getElementById('scanCardBtn')
scanCardBtn.addEventListener('click', () => {
    scanCardBtn.innerHTML = `
            <div class="spinner-border text-light" role="status">
                <span style= "font-size:10px;" class="visually-hidden">Loading...</span>
            </div>
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
    addcard_popup_msgArea.innerHTML = `
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
                    let uid = response.split(':')[1].split(',')[0].trim()
                    let cef = response.split(':')[1].split(',')[1].trim()
                    document.getElementById('card_uid').value = uid
                    clearInterval(readingCard)
                    if (cef != '') {
                        addMSG('info','this card is already registered for another student!')
                    }
                    scanCardBtn.innerHTML = 'scan'

                }
                else {
                    console.log('aucun carte')
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