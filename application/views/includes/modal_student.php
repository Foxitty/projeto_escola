<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-student-new" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="form_student" action="" method="post" class="needs-validation" novalidate>
                <div class="modal-header">
                    <div class="header-area d-flex justify-content-between align-items-center w-100">
                        <div class="d-flex align-items-center">
                            <h5 class="modal-title"></h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="name" class="form-label">Nome do aluno</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-sm-3">
                            <label for="birthday" class="form-label">Data de Nascimento</label>
                            <input type="date" min="1900-01-01" max="2999-12-31" class="form-control" id="birthday"
                                name="birthday" required>
                        </div>

                        <div class="col-sm-3">
                            <label for="gender" class="form-label">Gênero</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Selecione</option>
                                <option value="1">Masculino</option>
                                <option value="2">Feminino</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-6">
                            <label for="mother_name" class="form-label">Nome da mãe</label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" required>
                        </div>

                        <div class="col-sm-6">
                            <label for="father_name" class="form-label">Nome do pai</label>
                            <input type="text" class="form-control" id="father_name" name="father_name">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary save-btn">
                        <span class="d-flex justify-content-center align-items-center gap-2">Salvar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>