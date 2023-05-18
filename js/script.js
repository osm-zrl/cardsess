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
function resetcard() {
    let resetcard = document.getElementById('resetcard');
    if (resetcard.classList.contains('hidden')) {
        resetcard.classList.remove('hidden');
        resetcard.classList.add('displayed');
        black_layer.style.right = 0
    } else {
        resetcard.classList.add('hidden');
        resetcard.classList.remove('displayed');
        black_layer.style.right = '-100vw'
    }
}
