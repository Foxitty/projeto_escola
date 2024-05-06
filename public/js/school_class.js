$(document).ready(function () {

    $('#form-school-class').submit(function (event) {
        if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    $('#capacity').mask('000000', { reverse: true, placeholder: "" });

    const currentYear = new Date().getFullYear();
    const select = $('#school_year');
    for (var i = currentYear - 3; i <= currentYear + 5; i++) {
        select.append($('<option>', {
            value: i,
            text: i
        }));
    }

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
        $('#class_year').val('');
        $('#period').val('');

    });

    $('.edit-school-class-btn').on('click', function () {
        const schoolClassId = $(this).data('id');

        $('#form-school-class').attr('action', '/projeto_escola/turma/editar/' + schoolClassId);
        $('.save-btn').text('Salvar');
        $('.save-btn').removeClass('btn-danger').addClass('btn-primary');
        $('.modal-title').text('Editar Turma');

        $.ajax({
            url: '/projeto_escola/turma/' + schoolClassId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#class_name').val(data.class_name).prop('readonly', false);
                $('#capacity').val(data.capacity).prop('readonly', false);
                $('#living_room').val(data.living_room).prop('readonly', false);
                $('#school_year').val(data.school_year).prop('disabled', false);
                $('#period').val(data.period).prop('disabled', false);
                $('#class_year').val(data.class_year).prop('disabled', false);
            },
            error: function (error) {
                console.log('Erro ao obter dados da Turma:', error);
            }
        });

    });

    $('.delete-school-class-btn').on('click', function () {
        const schoolClassId = $(this).data('id');

        $('#form-school-class').attr('action', '/projeto_escola/turma/deletar/' + schoolClassId);
        $('.save-btn').text('Deletar');
        $('.save-btn').removeClass('btn-primary').addClass('btn-danger');
        $('.modal-title').text('Deletar Turma');

        $.ajax({
            url: '/projeto_escola/turma/' + schoolClassId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#class_name').val(data.class_name).prop('readonly', true);
                $('#capacity').val(data.capacity).prop('readonly', true);
                $('#living_room').val(data.living_room).prop('readonly', true);
                $('#school_year').val(data.school_year).prop('disabled', true);
                $('#class_year').val(data.class_year).prop('disabled', true);
                $('#period').val(data.period).prop('disabled', true);
            },
            error: function (error) {
                console.log('Erro ao obter dados da Turma:', error);
            }
        });

    });


});