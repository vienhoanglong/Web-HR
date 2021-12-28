$(document).ready(function(){$('#sidebar-collapse').on('click',function(){$('#sidebar').toggleClass('active');});});
// show dialog create employee
$(document).ready(function () {
    $(".click-create-employee").click(function () {
        $('#create-employee').modal({
            backdrop: 'static',
            keyboard: true, 
            
        });
    });
});

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}

$(document).on('click','#btn-create-employee',function(){
    var fullname = $('#fullname').val();
    var username = $('#username').val();
    var position = $('#position').val();
    var department = $('#department').val();
    var email = $('#email').val();
    
    //Kiểm tra lỗi
    if (fullname == '') {
        $('#er-fullname').html('Vui lòng nhập tên đẩy đủ!');
    } else if (username == '') {
        $('#er-username').html('Vui lòng nhập tên tài khoản!');
    } else if (position == '') {
        $('#er-position').html('Vui lòng chọn chức vụ!');
    } else if (department == '') {
        $('#er-department').html('Vui lòng chọn phòng ban!');
    } else if (email == '' || IsEmail(email) == false) {
        $('#er-email').html('Email không hợp lệ hoặc trống!');
    } else{
        $.ajax({
        type: 'post',
        dataType : 'JSON',
        url: 'management_employee.php',
        data: {fullname:fullname, username:username, position: position, department: department, email:email},
        success: function(data) {
            console.log(data);
            if (data.hasOwnProperty('error') && data.error == '1'){
                var html ='';
                // Lặp qua các key và xử lý nối lỗi
                $.each(data, function(key, item){
                    // Tránh key error ra vì nó là key thông báo trạng thái
                    if (key != 'error'){ 
                        html += '<li>'+item+'</li>';
                    }
                });
                $('.alert-danger').html(html).removeClass('hide');
            }
            else{ // Thành công
                $('.alert-success').html('Tạo tài khoản thành công!');
                // 4 giay sau sẽ tắt popup
                setTimeout(function(){
                    $('#create-employee').modal('hide');
                    location.reload();
                }, 4000);
                
            }
        }
        })
    }
})

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
//show dialog details department
$(document).ready(function () {
    $(".click-details-department").click(function () {
        $('#details-department').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
//show dialog detail calender
$(document).ready(function () {
    $(".click-detail-calender").click(function () {
        $('#detail-calender').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
//Show dialog cancel calender
$(document).ready(function () {
    $(".click-cancel-calender").click(function () {
        $('#cancel-calendar').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
//Show dialog create calendar
$(document).ready(function () {
    $(".create-calender-tp").click(function () {
        $('#create-calendar').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
