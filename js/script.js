function toggleAddStudent() {
    let addStudent = document.getElementById('addstudent');
    if (addStudent.classList.contains('hidden')) {
    addStudent.classList.remove('hidden');
    } else {
    addStudent.classList.add('hidden');
    }
    }