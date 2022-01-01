$(document).ready(function(){$('#sidebar-collapse').on('click',function(){$('#sidebar').toggleClass('active');});});
// $(document).on('click', '.components li', function() {
//     $(".components li").removeClass("active");
//     $(this).addClass("active");
// });

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
                // 2 giay sau sẽ tắt popup
                setTimeout(function(){
                    $('#create-employee').modal('hide');
                    location.reload();
                }, 1000);
                
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
        var update_empid = $(this).closest('tr').find('#id-employee').text();
        //console.log(update_empid);
        $('#ud_employee_id').val(update_empid);
        $.ajax({
            type:'post',
            url: 'management_employee.php',
            dataType:'JSON',
            data:{checking_edit:true, ud_employee_id:update_empid},
            success: function(data){
                //console.log(data);
                $.each(data, function(key, value){
                    //console.log(value)
                    $('#update_fullname').val(value['fullname']);
                    $('#update_user').val(value['username']);
                    $('#update_position').val(value['position']);
                    // $('#employee_position').val(value['position']);
                    // var tmp = $(this).val(value['position']);
                    // var checked = $(this).val(value['position'])[0].position;
                    // if(checked == 'Manager'){
                    //     $("#checked_manager").prop("checked", true);
                    // }else{
                    //     $('#checked_employee').prop('checked', true)
                    // }
                    $('#update_department').val(value['department']);
                    $('#update_email').val(value['email']);
                });
               
            }
        })
        
    });
});
$(document).on('click', '#btn-update-employee', function(){
    var ud_employee_id = $('#ud_employee_id').val();
    var fullname = $('#update_fullname').val();
    var username = $('#update_user').val();
    var username = $('#update_position').val();
    // var position = $('input[name="update_position"]:checked').val();
    var department = $('#update_department').val();
    console.log(department);
    var email = $('#update_email').val();
    if(fullname == ''){
        $('#ud-err-fullname').html('Vui lòng nhập tên đẩy đủ!');
    }else if (username == '') {
        $('#ud-err-username').html('Vui lòng nhập tên tài khoản!');
    } else if (position == '') {
        $('#ud-err-position').html('Vui lòng chọn chức vụ!');
    } else if (email == '' || IsEmail(email) == false) {
        $('#ud-err-email').html('Email không hợp lệ hoặc trống!');
    } else{
        $.ajax({
            type: 'post',
            dataType : 'JSON',
            url: 'management_employee.php',
            data: {ud_employee_fullname:fullname, ud_employee_username:username, ud_employee_position: position, ud_employee_department:department, ud_employee_email:email, ud_employee_id: ud_employee_id},
            success: function(data) {
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
                    $('.alert-success').html('Cập nhật tài khoản thành công!');
                    // 2 giay sau sẽ tắt popup
                    setTimeout(function(){
                        $('#update-employee').modal('hide');
                        location.reload();
                    }, 1000);
                    
                }
            }
        })
    }
})
// show dialog delete employee
$(document).ready(function () {
    $(".click-delete-employee").click(function () {
        $('#delete-employee').modal({
            backdrop: 'static',
            keyboard: false
        });
        var employee_id = $(this).closest('tr').find('#id-employee').text();
        //console.log(employee_id);
        $('#employee_id').val(employee_id);
    });
});
$(document).on('click','#btn-delete-employee',function(){
    var employee_id =  $('#employee_id').val();
    // console.log('ID Employee:', employee_id);
    if(employee_id ==''){
        alert('Thao tác xóa bị lỗi')
    }else{
        $.ajax({
            type: 'post',
            dataType : 'JSON',
            url: 'management_employee.php',
            data: {employee_id:employee_id},
            success: function(data) {
                setTimeout(function(){
                    $('#delete-employee').modal('hide');
                    location.reload();
                }, 1000);
                    
            }
        })
    }
    
});
//show dialog re-password employee
$(document).ready(function () {
    $(".click-reset-password").click(function () {
        $('#re-password-employee').modal({
            backdrop: 'static',
            keyboard: false
        });
        var update_empid = $(this).closest('tr').find('#id-employee').text();
        //console.log(update_empid);
        $('#rs_employee_id').val(update_empid);
    });
});
$(document).on('click','#btn-reset-password',function(){
    var rs_employee_id =  $('#rs_employee_id').val();
    if(rs_employee_id ==''){
        alert('Thao tác xóa bị lỗi')
    }else{
        $.ajax({
            type: 'post',
            dataType : 'JSON',
            url: 'management_employee.php',
            data: {rs_employee_id:rs_employee_id},
            success: function(data) {
                setTimeout(function(){
                    $('#re-password-employee').modal('hide');
                    location.reload();
                }, 1000);            
            }
        })
    }
})
//Show details employee
$(document).ready(function () {
    $(".click-details-employee").click(function () {
        $('#details-employee').modal({
            backdrop: 'static',
            keyboard: false
        });
        var load_employee_id = $(this).closest('tr').find('#id-employee').text();
        $('#load_employee_id').val(load_employee_id);
        $.ajax({
            type:'post',
            url: 'management_employee.php',
            dataType:'JSON',
            data:{checking_edit:true, ud_employee_id:load_employee_id},
            success: function(data){
                // console.log(data);
                $.each(data, function(key, value){
                    // console.log(value)
                    $('#load_fullname').val(value['fullname']);
                    $('#load_user').val(value['username']);
                    $('#load_position').val(value['position']);  
                    $('#load_department').val(value['department']);
                    $('#load_email').val(value['email']);
                });
               
            }
        })
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


