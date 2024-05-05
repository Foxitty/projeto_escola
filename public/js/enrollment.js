$(document).ready(function () {
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
            const removedStudent = includedStudents[index];
            removedStudents.push(removedStudent);
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

    $('.search-input').on('change', function () {

        if (includedStudents.length >= capacity) {
            capacityAlert.show();
            return;
        }

        const registration = $('.search-input').val();

        $('#student-list').empty();

        $.ajax({
            url: `/projeto_escola/enturmacao/matricula/${registration}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const age = calculateAge(data.birthday);

                const alreadyIncluded = includedStudents.some(student => student.id === data.id);
                if (alreadyIncluded) {
                    $('#capacity-alert').text('Aluno já adicionado à turma.').show();
                    return;
                }

                const newStudentTable = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                <th>Idade</th>
                                <th>Adicionar Aluno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>${data.registration_number}</td>
                                <td>${data.name}</td>
                                <td>${age}</td>
                                <td>
                                    <input type="checkbox" class="form-check-input" id="select-${data.registration_number}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                `;
                $('#student-list').empty();
                $('#student-list').append(newStudentTable);

                $(`#select-${data.registration_number}`).on('change', function () {
                    if ($(this).is(':checked')) {
                        includedStudents.push(data);
                        renderStudentList();
                    }
                });
            },
            error: function (error) {
                console.log('Aluno não encontrado.', error);
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
