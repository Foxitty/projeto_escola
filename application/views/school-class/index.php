<div class="d-flex flex-row-reverse mb-3">
    <a data-bs-toggle="modal" data-bs-target="#modal-form" class="btn btn-sm create-school-class-btn btn-primary">
        <span class="text-dark text-white">Adicionar Turma</span>
    </a>
</div>
<div class="transparent-border">
    <?php if (!empty($school_classes)): ?>
        <table class="table table-striped dataTable" style="width:100%">
            <thead>
                <tr>
                    <th>Nome da turma</th>
                    <th>Sala</th>
                    <th>Período</th>
                    <th>Série</th>
                    <th>Ano letivo</th>
                    <th>Quantidade de alunos</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($school_classes as $school_class): ?>
                    <tr class="text-center">
                        <td><?= $school_class['class_name'] ?></td>
                        <td><?= $school_class['living_room'] ?></td>
                        <td><?= getPeriodDescription($school_class['period']) ?></td>
                        <td><?= getClassYearDescription($school_class['class_year']) ?></td>
                        <td><?= $school_class['school_year'] ?></td>
                        <td><?= $school_class['enrolled_count'] ?> / <?= $school_class['capacity'] ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info create-enrollment-btn"
                                data-capacity="<?= $school_class['capacity'] ?>" data-id="<?= $school_class['id'] ?>"
                                data-bs-toggle="modal" data-bs-target="#modal-form-enrollment">Enturmar</a>
                            <a href="#" class="btn btn-sm btn-secondary edit-school-class-btn"
                                data-id="<?= $school_class['id'] ?>" data-bs-toggle="modal"
                                data-bs-target="#modal-form">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger delete-school-class-btn"
                                data-id="<?= $school_class['id'] ?>" data-bs-toggle="modal"
                                data-bs-target="#modal-form">Deletar</a>
                            <a href="<?= base_url('report/turma/' . $school_class['id']) ?>"
                                class="btn btn-sm btn-warning">Relatório</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-secondary">Não existem turmas cadastradas.</div>
    <?php endif; ?>
</div>

</div>

<script src="public/js/school_class.js"></script>