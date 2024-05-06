$(document).ready(function () {

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    let includedStudents = [];
    let removedStudents = [];
    let capacity = 0;

    const capacityAlert = $('#capacity-alert');
    const capacityIndicator = $('#capacity-indicator');

    function renderStudentList() {
        const studentTable = $('#student-table');
        const studentTableBody = $('#student-table-body');

        studentTableBody.empty();

        if (includedStudents.length === 0) {
            studentTable.hide();
            return;
        }

        studentTable.show();

        includedStudents.forEach((student, index) => {
            const age = calculateAge(student.birthday);

            studentTableBody.append(`
                <tr class="student-entry">
                    <td>${student.registration_number}</td>
                    <td>${student.name}</td>
                    <td>${age}</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-student" data-index="${index}">Remover</button>
                    </td>
                </tr>
            `);
        });

        capacityIndicator.text(`${includedStudents.length} / ${capacity}`);


        if (includedStudents.length >= capacity) {
            capacityAlert.show();
        } else {
            capacityAlert.hide();
        }

        $('.remove-student').on('click', function () {
            const index = $(this).data('index');
            removedStudents.push(includedStudents[index]);
            includedStudents.splice(index, 1);
            renderStudentList();
        });
    }

    function calculateAge(birthday) {
        const birthDate = new Date(birthday);

        if (isNaN(birthDate.getTime())) {
            return 'Desconhecida';
        }

        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();

        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age;
    }

    function isStudentAlreadyIncluded(includedStudents, studentId) {
        const idToCheck = Number(studentId);

        return includedStudents.some(student => Number(student.id) === idToCheck);
    }

    function addStudentToList(includedStudents, student, capacity) {

        if (!isStudentAlreadyIncluded(includedStudents, student.id)) {
            if (includedStudents.length < capacity) {
                includedStudents.push(student);
                renderStudentList();
            } else {
                alert('Capacidade máxima atingida.');
            }
            $('#capacity-alert').hide()
        } else {
            $('#capacity-alert').show().text('Aluno já está incluído.');
        }
    }

    $('.search-input').on('change', function () {
        if (includedStudents.length >= capacity) {
            $('#capacity-alert').show();
            return;
        }

        const searchTerm = $('.search-input').val();

        $('#student-list').empty();

        const studentTable = `
            <table class="table">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>Selecionar</th>
                    </tr>
                </thead>
                <tbody id="student-table-body-search">
                </tbody>
            </table>
        `;

        $('#student-list').append(studentTable);

        $.ajax({
            url: `/projeto_escola/enturmacao/buscar/${searchTerm}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const studentTableBody = $('#student-table-body-search');

                if (data.length === 0) {
                    studentTableBody.append(`
                        <tr>
                            <td colspan="4" class="text-center">Nenhum aluno encontrado.</td>
                        </tr>
                    `);
                } else {
                    data.forEach(student => {
                        const age = calculateAge(student.birthday);

                        studentTableBody.append(`
                            <tr>
                                <td>${student.registration_number}</td>
                                <td>${student.name}</td>
                                <td>${age} anos</td>
                                <td>
                                    <input type="checkbox" class="form-check-input" id="select-${student.registration_number}">
                                </td>
                            </tr>
                        `);

                        $(`#select-${student.registration_number}`).on('change', function () {
                            if ($(this).is(':checked')) {
                                addStudentToList(includedStudents, student, capacity);
                            }
                        });
                    });
                }
            },
            error: function (error) {
                console.log('Erro ao buscar alunos.', error);
            }
        });
    });

    $('#form-enrollment').on('submit', function () {
        const studentsField = $('#students-field');
        studentsField.val(JSON.stringify(includedStudents));

        const removedField = $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'removed_students')
            .val(JSON.stringify(removedStudents));

        $(this).append(removedField);
    });

    $('.create-enrollment-btn').on('click', function () {
        capacity = $(this).data('capacity');
        const schoolClassId = $(this).data('id');
        $('#school_class_id').val(schoolClassId);
        $('#form-enrollment').attr('action', '/projeto_escola/enturmacao/criar');

        includedStudents = [];
        removedStudents = [];
        capacityAlert.hide();
        capacityIndicator.text(`${includedStudents.length} / ${capacity}`);


        $.ajax({
            url: `/projeto_escola/enturmacao/listar/${schoolClassId}`,
            type: 'GET',
            dataType: 'json',
            success: function (students) {
                includedStudents = students;
                renderStudentList();
            },
            error: function (error) {
                console.log('Erro ao buscar alunos associados à turma.', error);
            }
        });
    });
});
