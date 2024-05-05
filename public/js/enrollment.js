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

        capacityIndicator.text(`${includedStudents.length} / ${capacity}`); // Atualiza o indicador

        if (includedStudents.length >= capacity) {
            capacityAlert.show(); // Exibe alerta se atingir ou ultrapassar capacidade
        } else {
            capacityAlert.hide(); // Esconde alerta se estiver abaixo da capacidade
        }

        $('.remove-student').on('click', function () {
            const index = $(this).data('index');
            removedStudents.push(includedStudents[index]); // Adiciona ao array de removidos
            includedStudents.splice(index, 1); // Remove do array de incluídos
            renderStudentList(); // Atualiza a tabela
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
        if (includedStudents.length >= capacity) { // Verifica se a capacidade foi atingida
            capacityAlert.show();
            return;
        }

        const searchTerm = $('.search-input').val(); // Termo para busca

        $('#student-list').empty(); // Limpa a lista de resultados

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

        $('#student-list').append(studentTable); // Adiciona a estrutura da tabela para resultados da busca

        $.ajax({
            url: `/projeto_escola/enturmacao/buscar/${encodeURIComponent(searchTerm)}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const studentTableBody = $('#student-table-body-search');

                data.forEach(student => {
                    const age = calculateAge(student.birthday);

                    studentTableBody.append(`
                        <tr>
                            <td>${student.registration_number}</td>
                            <td>${student.name}</td>
                            <td>${age}</td>
                            <td>
                                <input type="checkbox" class="form-check-input" id="select-${student.registration_number}">
                            </td>
                        </tr>
                    `);

                    $(`#select-${student.registration_number}`).on('change', function () {
                        if ($(this).is(':checked')) {
                            if (includedStudents.length < capacity) {  // Limita seleção pela capacidade
                                includedStudents.push(student); // Adiciona ao array de incluídos
                                renderStudentList(); // Atualiza a tabela final
                            } else {
                                alert('Capacidade máxima atingida.'); // Se a capacidade for atingida, impede a seleção
                                $(this).prop('checked', false); // Desmarca o checkbox
                            }
                        }
                    });
                });
            },
            error: function (error) {
                console.log('Erro ao buscar alunos.', error); // Tratamento de erro
            }
        });
    });

    $('#form-enrollment').on('submit', function () {
        const studentsField = $('#students-field');
        studentsField.val(JSON.stringify(includedStudents)); // Adiciona alunos incluídos ao formulário

        const removedField = $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'removed_students')
            .val(JSON.stringify(removedStudents)); // Campo oculto para removidos

        $(this).append(removedField); // Adiciona ao formulário para envio
    });

    $('.create-enrollment-btn').on('click', function () {
        capacity = $(this).data('capacity'); // Define a capacidade
        const schoolClassId = $(this).data('id'); // Define o ID da turma
        $('#school_class_id').val(schoolClassId);
        $('#form-enrollment').attr('action', '/projeto_escola/enturmacao/criar');

        includedStudents = []; // Limpa os alunos incluídos
        removedStudents = []; // Limpa os alunos removidos
        capacityAlert.hide(); // Esconde o alerta
        capacityIndicator.text(`${includedStudents.length} / ${capacity}`); // Atualiza o indicador

        $.ajax({
            url: `/projeto_escola/enturmacao/listar/${schoolClassId}`, // Obtém alunos existentes para a turma
            type: 'GET',
            dataType: 'json',
            success: function (students) {
                includedStudents = students; // Define os alunos incluídos inicialmente
                renderStudentList(); // Atualiza a tabela
            },
            error: function (error) {
                console.log('Erro ao buscar alunos associados à turma.', error);
            }
        });
    });
});
