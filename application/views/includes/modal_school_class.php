<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-school-class-new" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="form-school-class" action="" method="post" class="needs-validation" novalidate>
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
              <label for="class_name" class="form-label">Nome da turma</label>
              <input type="text" class="form-control" id="class_name" name="class_name" required>
            </div>

            <div class="col-sm-3">
              <label for="capacity" class="form-label">Capacidade da turma</label>
              <input type="text" class="form-control" id="capacity" name="capacity" required>
            </div>

            <div class="col-sm-3">
              <label for="living_room" class="form-label">Sala</label>
              <input type="text" class="form-control" id="living_room" name="living_room" required>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-sm-3">
              <label for="school_year" class="form-label">Ano letivo</label>
              <select class="form-select" id="school_year" name="school_year" required>
                <option value="">Selecione</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label for="class_year" class="form-label">Série</label>
              <select class="form-select" id="class_year" name="class_year" required>
                <option value="">Selecione</option>
                <option value="1">1º Ano</option>
                <option value="2">2º Ano</option>
                <option value="3">3º Ano</option>
                <option value="4">4º Ano</option>
                <option value="5">5º Ano</option>
                <option value="6">6º Ano</option>
                <option value="7">7º Ano</option>
                <option value="8">8º Ano</option>
                <option value="9">9º Ano</option>
              </select>
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