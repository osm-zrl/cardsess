const black_layer = document.getElementById('black_layer')

function togglecard() {
    let addStudent = document.getElementById('addstudent');
    if (addStudent.classList.contains('hidden')) {
        addStudent.classList.remove('hidden');
        addStudent.classList.add('displayed');
        black_layer.style.right = 0
    } else {
        addStudent.classList.add('hidden');
        addStudent.classList.remove('displayed');
        black_layer.style.right = '-100vw'
    }
}
function toggleDisablecard() {
    let disableCard = document.getElementById('disableCard');
    if (disableCard.classList.contains('hidden')) {
        disableCard.classList.remove('hidden');
        disableCard.classList.add('displayed');
        black_layer.style.right = 0
    } else {
        disableCard.classList.add('hidden');
        disableCard.classList.remove('displayed');
        black_layer.style.right = '-100vw'
    }
}
   