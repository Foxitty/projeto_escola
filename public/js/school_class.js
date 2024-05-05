$(document).ready(function () {

    $('#form-school-class').submit(function (event) {
        if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    const activeTab = () => {
        $('.menu-nav .nav-item:last-child .nav-link').addClass('text-decoration-underline');
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

    $('.create-school-class-btn').on('click', function () {
        $('#form-school-class').attr('action', '/projeto_escola/turma/criar');
        $('.save-btn').text('Salvar');
        $('.save-btn').removeClass('btn-danger').addClass('btn-primary');
        $('.modal-title').text('Nova Turma');
        $('#class_name').val('');
        $('#capacity').val('');
        $('#living_room').val('');
        $('#school_year').val('');

    });

    $('.edit-school-class-btn').on('click', function () {
        const studentId = $(this).data('id');

        $('#form-school-class').attr('action', '/projeto_escola/turma/editar/' + studentId);
        $('.save-btn').text('Salvar');
        $('.save-btn').removeClass('btn-danger').addClass('btn-primary');
        $('.modal-title').text('Editar Turma');

        $.ajax({
            url: '/projeto_escola/turma/' + studentId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#class_name').val(data.class_name).prop('readonly', false);
                $('#capacity').val(data.capacity).prop('readonly', false);
                $('#living_room').val(data.living_room).prop('readonly', false);
                $('#school_year').val(data.school_year).prop('readonly', false);
            },
            error: function (error) {
                console.log('Erro ao obter dados da Turma:', error);
            }
        });

    });

    $('.delete-school-class-btn').on('click', function () {
        const studentId = $(this).data('id');

        $('#form-school-class').attr('action', '/projeto_escola/turma/deletar/' + studentId);
        $('.save-btn').text('Deletar');
        $('.save-btn').removeClass('btn-primary').addClass('btn-danger');
        $('.modal-title').text('Deletar Turma');

        $.ajax({
            url: '/projeto_escola/turma/' + studentId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#class_name').val(data.class_name).prop('readonly', true);
                $('#capacity').val(data.capacity).prop('readonly', true);
                $('#living_room').val(data.living_room).prop('readonly', true);
                $('#school_year').val(data.school_year).prop('readonly', true);
            },
            error: function (error) {
                console.log('Erro ao obter dados da Turma:', error);
            }
        });

    });


});