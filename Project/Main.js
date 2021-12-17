$(document).ready(function(){$('#sidebar-collapse').on('click',function(){$('#sidebar').toggleClass('active');});});
// show dialog create employee
$(document).ready(function () {
    $(".click-create-employee").click(function () {
        $('#create-employee').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
// show dialog update employee
$(document).ready(function () {
    $(".click-update-employee").click(function () {
        $('#update-employee').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
// show dialog delete employee
$(document).ready(function () {
    $(".click-delete-employee").click(function () {
        $('#delete-employee').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
//show dialog re-password employee
$(document).ready(function () {
    $(".click-reset-password").click(function () {
        $('#re-password-employee').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
//show dialog create department
$(document).ready(function () {
    $(".click-create-department").click(function () {
        $('#create-department').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
//show dialog create promote
$(document).ready(function () {
    $(".click-create-promote").click(function () {
        $('#create-promote').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
// show dialog update department
$(document).ready(function () {
    $(".click-update-department").click(function () {
        $('#update-department').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
// show dialog delete employee
$(document).ready(function () {
    $(".click-delete-department").click(function () {
        $('#delete-department').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});