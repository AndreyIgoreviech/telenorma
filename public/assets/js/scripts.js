const base_path_rest_api = "http://localhost:1111/api/";

$(window).on('load', function () {
    initRoles();
});

const initRoles = () => {
    $.ajax({
        url: base_path_rest_api + 'roles',
        method: 'GET',
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

const exception = (errorObj = null) => {
    if (errorObj) {
        console.error(errorObj);
    } else {
        console.error('There was some error performing the AJAX call!');
    }
}
