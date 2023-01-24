const base_path_rest_api = "http://localhost:1111/api/";
let isAjaxLoading = false;

$(window).on('load', function () {
    initRoles();

    let users = loadUsers()
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
            createUser(firstname, lastname, roleId)
                .then((user) => {
                    isAjaxLoading = false;
                    if (user) {
                        form.removeClass('was-validated').trigger('reset');
                        addRow(user);
                    }
                })
                .catch(() => {
                    isAjaxLoading = false;
                });
        }
        form.addClass('was-validated');
    }
}

const createUser = (firstname, lastname, roleId) => {
    return $.ajax({
        url: base_path_rest_api + 'users',
        method: 'PUT',
        dataType: "json",
        data: {
            firstname,
            lastname,
            roleId
        },
        error: (err) => exception(err)
    });
}

const deleteUser = (id) => {
    return $.ajax({
        url: base_path_rest_api + 'users',
        method: 'DELETE',
        dataType: "json",
        data: {
            id
        },
        success: (userId) => removeRow(userId),
        error: (err) => exception(err)
    });
}
