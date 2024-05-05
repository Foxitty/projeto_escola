<div class="modal fade" id="modal-form-enrollment" tabindex="-1" aria-labelledby="modal-enrollment-new"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="form-enrollment" action="" method="post">

                <div class="modal-header">
                    <div class="header-area d-flex justify-content-between align-items-center w-100">
                        <h5 class="modal-title">Incluir Alunos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <div id="capacity-alert" class="alert alert-danger" style="display: none;">
                    Capacidade máxima de alunos atingida.
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <label for="search-input" class="form-label">Buscar aluno</label>
                            <div class="input-group">
                                <input type="search" class="form-control search-input" id="search-input"
                                    placeholder="Buscar..." data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Digite o número de matrícula ou o nome do aluno">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div id="student-list">
                    </div>

                    <div id="student-table" class="border p-3 mt-3" style="display: none;">
                        <h6>Lista de alunos na turma</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Matrícula</th>
                                    <th>Nome</th>
                                    <th>Idade</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="student-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>

                <input type="hidden" id="students-field" name="students" value="">
                <input type="hidden" id="school_class_id" name="school_class_id" value="">

                <div class="modal-footer">
                    <span id="capacity-indicator"></span>
                    <button type="submit" class="btn btn-sm btn-primary save-btn">Salvar</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="public/js/enrollment.js"></script>