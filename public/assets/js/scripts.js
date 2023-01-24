const base_path_rest_api = "http://localhost:1111/api/";
let isAjaxLoading = false;

$(window).on('load', function () {
    initRoles();

    loadUsers()
        .then((users) => {
            $('table tbody').html('');
            if (users.length) {
                users.forEach((user) => addRow(user));
            }
        });
});

const exception = (errorObj = null) => {
    if (errorObj) {
        console.error(errorObj.status + ": " + errorObj.responseJSON.message);
    } else {
        console.error('There was some error performing the AJAX call!');
    }
}

const initRoles = () => {
    $.ajax({
        url: base_path_rest_api + 'roles',
        method: 'GET',
        dataType: "json",
        success: (roles) => {
            if (roles?.length) {
                roles.forEach((role) => {
                    $("#selectRole").append('<option value="' + role.id + '">' + role.name + '</option>');
                });
            }
        },
        error: (err) => exception(err)
    });
}

const loadUsers = () => {
    return $.ajax({
        url: base_path_rest_api + 'users',
        method: 'GET',
        dataType: "json",
        error: (err) => exception(err)
    });
}

const addRow = (user) => {
    let template = $("template#user-table-row").html().toString();
    template = template.replace(/\{id\}/g, user.id);
    template = template.replace('{firstname}', user.firstname);
    template = template.replace('{lastname}', user.lastname);
    template = template.replace('{role}', user.role);
    template = template.replace('{created}', user.created);
    template = template.replace('{updated}', user.updated);
    $('table tbody').append(template);
}

const removeRow = (id) => {
    $('table tbody tr#user-id-' + id).remove();
}

const updateRow = (user) => {
    const row = $('table tbody tr#user-id-' + user.id);
    row.find('td').eq(0).text(user.firstname);
    row.find('td').eq(1).text(user.lastname);
    row.find('td').eq(2).text(user.role);
    row.find('td').eq(4).text(user.updated);
}

const addUser = (event) => {
    event.preventDefault();
    event.stopPropagation();
    if (!isAjaxLoading) {
        const form = $('form');
        const firstname = form.find('[name="firstname"]').val().trim();
        const lastname = form.find('[name="lastname"]').val().trim();
        const roleId = form.find('[name="roleId"]').val();
        if (firstname && lastname && roleId) {
            isAjaxLoading = true;
            $.ajax({
                url: base_path_rest_api + 'users',
                method: 'PUT',
                dataType: "json",
                data: {
                    firstname,
                    lastname,
                    roleId
                },
                success: (user) => {
                    if (user) {
                        form.removeClass('was-validated').trigger('reset');
                        addRow(user);
                    }
                    isAjaxLoading = false;
                },
                error: (err) => {
                    exception(err);
                    isAjaxLoading = false;
                }
            });
        }
        form.addClass('was-validated');
    }
}

const deleteUser = (id) => {
    if (!isAjaxLoading) {
        if (confirm("Are you sure?") === true) {
            isAjaxLoading = true;
            $.ajax({
                url: base_path_rest_api + 'users',
                method: 'DELETE',
                dataType: "json",
                data: {
                    id
                },
                success: (userId) => {
                    removeRow(userId);
                    isAjaxLoading = false;
                },
                error: (err) => {
                    exception(err);
                    isAjaxLoading = false;
                }
            });
        }
    }
}

const editUser = (id) => {
    if (id && !isAjaxLoading) {
        isAjaxLoading = true;
        return $.ajax({
            url: base_path_rest_api + 'users',
            method: 'GET',
            dataType: "json",
            data: {
                id
            },
            success: (user) => {
                if (user) {
                    const form = $('form');
                    form.find('[name="id"]').val(id);
                    form.find('[name="firstname"]').val(user.firstname);
                    form.find('[name="lastname"]').val(user.lastname);
                    form.find('[name="roleId"]').val(user.roleId);
                    $('#button-update').removeClass('d-none');
                    $('#button-add').addClass('d-none');
                }
                isAjaxLoading = false;
            },
            error: (err) => {
                exception(err);
                isAjaxLoading = false;
            }
        });
    }
}

const updateUser = () => {
    event.preventDefault();
    event.stopPropagation();
    if (!isAjaxLoading) {
        const form = $('form');
        const id = form.find('[name="id"]').val();
        const firstname = form.find('[name="firstname"]').val().trim();
        const lastname = form.find('[name="lastname"]').val().trim();
        const roleId = form.find('[name="roleId"]').val();
        if (firstname && lastname && roleId) {
            isAjaxLoading = true;
            $.ajax({
                url: base_path_rest_api + 'users',
                method: 'POST',
                dataType: "json",
                data: {
                    id,
                    firstname,
                    lastname,
                    roleId
                },
                success: (user) => {
                    if (user) {
                        $('#button-update').addClass('d-none');
                        $('#button-add').removeClass('d-none');
                        form.removeClass('was-validated').trigger('reset');
                        updateRow(user);
                    }
                    isAjaxLoading = false;
                },
                error: (err) => {
                    exception(err);
                    isAjaxLoading = false;
                }
            });
        }
        form.addClass('was-validated');
    }
}
