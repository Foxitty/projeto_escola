<div class="d-flex flex-row-reverse mb-3">
    <a data-bs-toggle="modal" data-bs-target="#modal-form" class="btn btn-sm create-student-btn btn-primary">
        <span class="text-dark text-white">Adicionar Aluno</span>
    </a>
</div>
<div class="transparent-border">
    <?php if (!empty($students)): ?>
    <table class="table table-striped dataTable">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Data de Nasc</th>
                <th>Nome da Mãe</th>
                <th>Gênero</th>
                <th>Turma</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody class="text-start">
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['registration_number'] ?></td>
                <td><?= $student['name'] ?></td>
                <td><?= (new DateTime($student['birthday']))->format('d/m/Y') ?></td>
                <td><?= $student['mother_name'] ?></td>
                <td><?= getGenderDescription($student['gender']) ?></td>
                <td><?= $student['class'] ?></td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-secondary edit-student-btn" data-id="<?= $student['id'] ?>"
                        data-bs-toggle="modal" data-bs-target="#modal-form">
                        Editar
                    </a>

                    <a href="#" data-id="<?= $student['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-form"
                        class="btn btn-sm btn-danger delete-student-btn">Deletar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-secondary">Não existem alunos cadastrados.</div>
    <?php endif; ?>
</div>
</div>

<script src="public/js/students.js"></script>