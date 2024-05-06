$(document).ready(function () {

    $('#form_student').submit(function (event) {
        if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    $('#phone').mask('(00) 0000-00009');
    $('#phone').blur(function (event) {
        if ($(this).val().length === 15) {
            $('#phone').mask('(00) 00000-0009');
        } else {
            $('#phone').mask('(00) 0000-00009');
        }
    });

    const activeTab = () => {
        $('.menu-nav .nav-item:first-child .nav-link').addClass('text-decoration-underline');
    }

    activeTab();

    $('.dataTable').DataTable({
        responsive: true,
        language: {
            sSearch: "",
            lengthMenu: "_MENU_ Resultados por página",
            searchPlaceholder: "Buscar...",
            info: "Mostrando de _START_ até _END_ de _TOTAL_ registros"
        },

    });

    $('.create-student-btn').on('click', function () {

        $('#form_student').attr('action', '/projeto_escola/aluno/criar/');
        $('.save-btn').text('Salvar');
        $('.save-btn').removeClass('btn-danger').addClass('btn-primary');
        $('.modal-title').text('Novo Aluno');
        $('#name').val('').prop('readonly', false);
        $('#phone').val('').prop('readonly', false);
        $('#birthday').val('').prop('readonly', false);
        $('#father_name').val('').prop('readonly', false);
        $('#mother_name').val('').prop('readonly', false);
        $('#gender').val('').prop('disabled', false);

    });

    $('.edit-student-btn').on('click', function () {
        const studentId = $(this).data('id');

        $('#form_student').attr('action', `/projeto_escola/aluno/editar/${studentId}`);
        $('.save-btn').text('Salvar');
        $('.save-btn').removeClass('btn-danger').addClass('btn-primary');
        $('.modal-title').text('Editar Aluno');

        $.ajax({
            url: '/projeto_escola/aluno/' + studentId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#name').val(data.name).prop('readonly', false);
                $('#phone').val(data.phone).prop('readonly', false);
                $('#birthday').val(data.birthday).prop('readonly', false);
                $('#father_name').val(data.father_name).prop('readonly', false);
                $('#mother_name').val(data.mother_name).prop('readonly', false);
                $('#gender').val(data.gender).prop('disabled', false);
            },
            error: function (error) {
                console.log('Erro ao obter dados do aluno:', error);
            }
        });

    });

    $('.delete-student-btn').on('click', function () {
        const studentId = $(this).data('id');

        $('#form_student').attr('action', `/projeto_escola/aluno/deletar/${studentId}`);
        $('.save-btn').text('Deletar');
        $('.save-btn').removeClass('btn-primary').addClass('btn-danger');
        $('.modal-title').text('Deletar Aluno');

        $.ajax({
            url: `/projeto_escola/aluno/${studentId}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#name').val(data.name).prop('readonly', true);
                $('#birthday').val(data.birthday).prop('readonly', true);
                $('#father_name').val(data.father_name).prop('readonly', true);
                $('#mother_name').val(data.mother_name).prop('readonly', true);
                $('#gender').val(data.gender).prop('disabled', true);
                $('#phone').val('').val(data.phone).prop('readonly', true);
            },
            error: function (error) {
                console.log('Erro ao obter dados do aluno:', error);
            }
        });

    });

});