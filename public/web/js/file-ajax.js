const inputs = document.querySelectorAll('#exampleModal input, select');
const form = document.getElementById('exampleModal');
const btn = document.querySelector('.button');
const id = $('#employee_payroll').val();
const permission = document.getElementById('ctrl_permission').value;
const expressions = {
    name: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    file: /^.*\.(jpg|JPG|gif|GIF|doc|DOC|pdf|PDF)$/, // Nombre del archivo letras y numeros sin espacios, ni acentos.
    int: /^[0-9]+$/,
};
/* Variables de control */
const fields = {
    employee_payroll: false,
    title: false,
    file: false,
    ctrl_permission: false
}

const validateForm = (e) => {
    switch (e.name) {
        case 'employee_payroll':
            validateSpecialFields(expressions.int, e)
            break;
        case 'title':
            validateFields(expressions.name, e, 'title')
            break;
        case 'file':
            validateFields(expressions.file, e, 'inputfile')
            break;
        case 'ctrl_permission':
            validateSpecialFields(expressions.int, e)
            break;
    }
};

const validateFields = (expression, input, field) => {
    if (expression.test(input.value)) {
        /* alt gr + }} */
        document.getElementById(`${field}`).classList.remove('is-invalid');
        document.getElementById(`${field}`).classList.add('is-valid');
        fields[input.name] = true;
    } else {
        document.getElementById(`${field}`).classList.remove('is-valid');
        document.getElementById(`${field}`).classList.add('is-invalid');
        setTimeout(() => {
            btn.classList.remove('btn-progress');
            btn.classList.remove('disabled');
        }, 1000);
        fields[input.name] = false;
    }
}

const validateSpecialFields = (expression, input) => {
    if (!expression.test(input.value)) {
        fields[input.name] = false;
        Swal.fire({
            title: 'Oops...',
            text: '¡Algo salió mal! Contacta a easuarez@vizcarra.com',
            icon: 'error',
            confirmButtonColor: '#6777ef',
            confirmButtonText: 'OK',
        })
    } else {
        fields[input.name] = true;
    }
}

$(function () {
    console.log("Designed by EASuarez :D");
    /*  Yajra DataTables */
    var table = $('#files').DataTable({
        serverSide: true,
        ajax: '/fetch-file/' + id,
        aLengthMenu: [
            [7, 20, 50, 100, -1],
            [7, 20, 50, 100, 'All'],
        ],
        iDisplayLength: 7,
        columns: [
            { data: 'id' },
            { data: 'path' },
            { data: 'employee_payroll' },
            { data: 'name' },
            { data: 'created_at' },
            { data: 'btn' },
        ],
        columnDefs: [
            { targets: [3, 4, 5], className: 'text-center' },
            { targets: [0, 1, 2], visible: false, searchable: false },
        ],
    });
    /* Limpiar modal al momento de abrir */
    $('#exampleModal').on('show.bs.modal', function (event) {
        btn.classList.remove('btn-progress');
        form.reset();
    });

    /* Guardar documento */
    $('#btn-register').on("click", function () {
        /* $(this).text('Enviando...'); */
        /* btn.classList.toggle('button--loading'); */
        btn.classList.add('btn-progress');
        btn.classList.add('disabled');
        /* Recorrer inputs del formulario y validar los mismos*/
        inputs.forEach((input) => {
            validateForm(input);
        });

        if (fields.ctrl_permission && fields.employee_payroll && fields.file && fields.title) {
            /* btn.classList.add('disabled'); */
            /* AJAX */
            var formData = new FormData(form);
            $.ajax({
                url: '/document/register',
                type: 'post',
                dataType: 'html',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            })
                .done(function (res) {
                    let obj = JSON.parse(res);
                    if (obj.response.status == 400) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: obj.response.msg,
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                        });
                        $('#btn-register').text('Guardar');
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado!',
                            text: obj.response.msg,
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                        });
                        form.reset();
                        $('#exampleModal').modal('hide');
                        document.querySelectorAll('.is-valid').forEach((item) => {
                            item.classList.remove('is-valid');
                        });
                        /* $('#btn-register').text('Guardar');*/
                        table.ajax.reload();
                    }
                })
                .fail(function (res) {
                    console.log(res);
                });
        }
    });
    /* no se usa, por el momento */
    $(document).on('click', '.editbtn', function (e) {
        e.preventDefault();
        var stud_id = $(this).val();
        // alert(stud_id);
        /* $('#editModal').modal('show'); */
        $.ajax({
            type: 'GET',
            url: '/edit-student/' + stud_id,
            success: function (response) {
                if (response.status == 404) {
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#editModal').modal('hide');
                } else {
                    // console.log(response.student.name);
                    $('#name').val(response.student.name);
                    $('#course').val(response.student.course);
                    $('#email').val(response.student.email);
                    $('#phone').val(response.student.phone);
                    $('#stud_id').val(stud_id);
                }
            },
        });
        $('.btn-close').find('input').val('');
    });
    /* No se usa, por el momento */
    $(document).on('click', '.update_student', function (e) {
        e.preventDefault();

        $(this).text('Updating..');
        var id = $('#stud_id').val();
        // alert(id);

        var data = {
            name: $('#name').val(),
            course: $('#course').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        $.ajax({
            type: 'PUT',
            url: '/update-student/' + id,
            data: data,
            dataType: 'json',
            success: function (response) {
                // console.log(response);
                if (response.status == 400) {
                    $('#update_msgList').html('');
                    $('#update_msgList').addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_value) {
                        $('#update_msgList').append(
                            '<li>' + err_value + '</li>'
                        );
                    });
                    $('.update_student').text('Update');
                } else {
                    $('#update_msgList').html('');

                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#editModal').find('input').val('');
                    $('.update_student').text('Update');
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                }
            },
        });
    });
    /* Eliminar registro */
    $(document).on('click', '.destroybtn', function (e) {
        e.preventDefault();
        if (permission === '1') {
            var id = $(this).val();

            Swal.fire({
                title: '¿Está segur@?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#fc544b',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'No, ¡espera!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf - token"]').attr(
                                'content'
                            ),
                        },
                    });

                    $.ajax({
                        type: 'DELETE',
                        url: '/destroy-file/' + id,
                        dataType: 'json',
                    })
                        .done(function (res) {
                            if (res.response.status == 400) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: res.response.msg,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                });
                                $('#btn-register').text('Guardar');
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Eliminado!',
                                    text: res.response.msg,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                });
                                table.ajax.reload();
                            }
                        })
                        .fail(function (res) {
                            console.log(res);
                        });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No cuentas con los permisos suficientes para esta acción.',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        }
    });
});
