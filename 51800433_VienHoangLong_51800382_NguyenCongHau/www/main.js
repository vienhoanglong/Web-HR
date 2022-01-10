$(document).ready(function(){$('#sidebar-collapse').on('click',function(){$('#sidebar').toggleClass('active');});});

// show modal create employee
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
// show modal update employee
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
    // console.log(department);
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
// show modal delete employee
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
//show modal re-password employee
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
//show modal create department
$(document).ready(function () {
    $(".click-create-department").click(function () {
        $('#create-department').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
$(document).on('click', '#btn-create-department', function() {
    var address = $('#address_room').val();
    var name = $('#name_room').val();
    var desc = $('#desc_room').val();
    (address == '') ? $('#er-address').html('Vui lòng nhập số phòng của phòng ban!'): $('#er-address').html('');
    (name == '') ? $('#er-name').html('Vui lòng nhập tên phòng ban!'): $('#er-name').html('');
    (desc == '') ? $('#er-desc').html('Vui lòng nhập mô tả về phòng ban!'): $('#er-desc').html('');
    if (address !== '' && name !== '' && desc !== '') {
        $.ajax({
            type: 'post',
            dataType: 'JSON',
            url: 'management_department.php',
            data: {
                name: name,
                address: address,
                desc: desc
            },
            success: function(data) {
                if (data.hasOwnProperty('error') && data.error == '1') {
                    var html = '';
                    // Lặp qua các key và xử lý nối lỗi
                    $.each(data, function(key, item) {
                        // Tránh key error ra vì nó là key thông báo trạng thái
                        if (key != 'error') {
                            html += '<li>' + item + '</li>';
                        }
                    });
                    $('.alert-danger').html(html).removeClass('hide');
                } else { // Thành công
                    $('.alert-success').html('Tạo phòng ban thành công!');
                    // 2 giay sau sẽ tắt popup
                    setTimeout(function() {
                        $('#create-department').modal('hide');
                        location.reload();
                    }, 1000);

                }
            }
        })
    }

})
//show modal create promote
$(document).ready(function () {
    $(".click-create-promote").click(function () {
        $('#create-promote').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});
$(document).on('click', '#btn-details-promote', $(document).ready(function () {
    $('.btn-details-promote').click(function () {
        $('#details-promote').removeClass('d-none');
        $('#footer-promote').removeClass('d-none');
        $('#department_promote').attr('disabled', true);
        //clear select option
        $('#user_promote')
        .find('option')
        .remove()
        .end()
        var id_department = $('#department_promote').val();
        console.log("name",id_department);
        $.ajax({
            type:'post',
            url: 'management_department.php',
            dataType:'JSON',
            data:{checking_promote:true, id_department_promote:id_department},
            success: function(data){
                var array = data;
                if (array != '')
                {
                  for (i in array) {                        
                   $("#user_promote").append('<option value='+array[i].username+'>'+array[i].username+'</option>');
                 }
                }     
            }
        })

    });
}))
$(document).ready(function () {
    $('#close-promote').click(function () {
        $('#department_promote').attr('disabled', false);
    });
})
$(document).on('click', '#btn-department-promote', function(){
    var department = $('#department_promote').val();
    var user = $('#user_promote').val();
    var position = $('#position_promote').val();
    //console.log(department, user, position);
    if (department !== '' && user !== '' && position !== '') {
        $.ajax({
            type: 'post',
            dataType: 'JSON',
            url: 'management_department.php',
            data: {
                department_promote: department,
                user_promote: user,
                position_promote: position
            },
            success: function(data) {
                if (data.hasOwnProperty('error') && data.error == '1') {
                    var html = '';
                    // Lặp qua các key và xử lý nối lỗi
                    $.each(data, function(key, item) {
                        // Tránh key error ra vì nó là key thông báo trạng thái
                        if (key != 'error') {
                            html += '<li>' + item + '</li>';
                        }
                    });
                    $('.alert-danger').html(html).removeClass('hide');
                } else { // Thành công
                    $('.alert-success').html('Bổ nhiểm/bãi nhiểm trưởng phòng thành công!');
                    // 2 giay sau sẽ tắt popup
                    setTimeout(function() {
                        $('#create-department').modal('hide');
                        location.reload();
                    }, 1000);

                }
            }
        })
    }
})
// show modal update department
$(document).ready(function() {
    $(".click-update-department").click(function() {
        $('#update-department').modal({
            backdrop: 'static',
            keyboard: false
        });
        var update_dpmid = $(this).closest('tr').find('#id-department').text();
        // console.log(update_dpmid);
        $('#ud_department_id').val(update_dpmid);
        $.ajax({
            type: 'post',
            url: 'management_department.php',
            dataType: 'JSON',
            data: {
                checking_load: true,
                ud_department_id: update_dpmid
            },
            success: function(data) {

                $.each(data, function(key, value) {
                    $('#update_name').val(value['nameDepartment']);
                    $('#update_address').val(value['addressDepartment']);
                    $('#update_desc').val(value['descDepartment']);
                });

            }
        })

    });
});
$(document).on('click', '#btn-update-department', function() {
    var ud_department_id = $('#ud_department_id').val();
    var name = $('#update_name').val();
    var address = $('#update_address').val();
    var desc = $('#update_desc').val();
    (name == '') ? $('#ud-err-name').html('Vui lòng nhập tên phòng ban!'): $('#ud-err-name').html('');
    (address == '') ? $('#ud-err-address').html('Vui lòng nhập số phòng!'): $('#ud-err-address').html('');
    (desc == '') ? $('#ud-err-desc').html('Vui lòng nhập mô tả phòng ban!'): $('#ud-err-desc').html('');
    if (address !== '' && name !== '' && desc !== '') {
        $.ajax({
            type: 'post',
            dataType: 'JSON',
            url: 'management_department.php',
            data: {
                ud_name: name,
                ud_address: address,
                ud_desc: desc,
                ud_id_department: ud_department_id
            },
            success: function(data) {
                if (data.hasOwnProperty('error') && data.error == '1') {
                    var html = '';
                    // Lặp qua các key và xử lý nối lỗi
                    $.each(data, function(key, item) {
                        // Tránh key error ra vì nó là key thông báo trạng thái
                        if (key != 'error') {
                            html += '<li>' + item + '</li>';
                        }
                    });
                    $('.alert-danger').html(html).removeClass('hide');
                } else { // Thành công
                    $('.alert-success').html('Cập nhật phòng bản thành công!');
                    // 2 giay sau sẽ tắt popup
                    setTimeout(function() {
                        $('#update-department').modal('hide');
                        location.reload();
                    }, 1000);

                }
            }
        })
    }

})
//show modal details department
$(document).ready(function() {
    $(".click-details-department").click(function() {
        $('#details-department').modal({
            backdrop: 'static',
            keyboard: false
        });
        var load_department_id = $(this).closest('tr').find('#id-department').text();
        //console.log(load_department_id);
        $('#load_department_id').val(load_department_id);
        $.ajax({
            type: 'post',
            url: 'management_department.php',
            dataType: 'JSON',
            data: {
                checking_load: true,
                ud_department_id: load_department_id
            },
            success: function(data) {
                // console.log(data);
                var tmp = (data[0]);
                $.each(data, function(key, value) {
                    //console.log(typeof(value))
                    $('#load_name').val(value['nameDepartment']);
                    $('#load_address').val(value['addressDepartment']);
                    $('#load_desc').val(value['descDepartment']);
                    $('#load_dpm_manager').val(value['manager']);
                    $('#load_quantity').val(tmp['count(position)']);
                })
            }
        })

    });

})
//Calendar bên trưởng phòng
//show modal detail calender
$(document).ready(function() {
    $(".click-detail-calender").click(function() {
        $('#detail-calender').modal({
            backdrop: 'static',
            keyboard: false
        });
        var id_calendar = $(this).closest('tr').find('#id_calendar_admin').text();
        //console.log(id_calendar);
        $('#load_calendar_id').val(id_calendar);
        $.ajax({
            type: 'post',
            url: 'calendar_admin.php',
            dataType: 'JSON',
            data: {
                checking_calendar: true,
                id_calendar: id_calendar
            },
            success: function(data) {
                //console.log(data);
                var data0 = data[0];
                var data1 = data[1];
                var data2 = data[2];
                $.each(data, function(key, value) {
                    $('#load_id_calendar').text(data1['id']);
                    $('#load_user_calendar').text(data1['fullname']);
                    $('#load_position_calendar').text(data1['position'] + '-' + data1['department']);
                    $('#load_dayoff').text(15 - data0['ngayConLai']);
                    $('#load_restday').text(data0['ngayConLai']);
                    var date1 = new Date(data2['ngayBatDau']);
                    var date2 = new Date(data2['ngayKetThuc']);
                    var difference = date2.getTime() - date1.getTime();
                    var days = Math.ceil(difference / (1000 * 3600 * 24));
                    $('#load_reqday').text(days + ' ngày');
                    $('#load_time').text('Từ ' + data2['ngayBatDau'] + ' đến ' + data2['ngayKetThuc']);
                    $('#load_reason').text(data2['liDo']);
                    if(data2['trangThai']==='Chờ duyệt'){
                        $('#status_calendar').text(data2['trangThai']);
                        $('#status_calendar').addClass('alert-warning')
                    }else if(data2['trangThai']==='Đã duyệt'){
                        $('#status_calendar').text(data2['trangThai']);
                        $('#status_calendar').addClass('alert-success')
                    }else{
                        $('#status_calendar').text(data2['trangThai']);
                        $('#status_calendar').addClass('alert-danger')
                    }
                })
            }
        })
    });
});
//Show modal cancel calender
$(document).ready(function () {
    $(".click-cancel-calender").click(function () {
        $('#cancel-calendar').modal({
            backdrop: 'static',
            keyboard: false
        });
        var idcancel_calendar = $(this).closest('tr').find('#id_calendar_admin').text();
        $('#idcancel_calendar').val(idcancel_calendar);
    });
});
$(document).on('click', '#btn_cancel_calendar',function(){
    var idcancel_calendar =  $('#idcancel_calendar').val();
    console.log(idcancel_calendar);
    if(idcancel_calendar == ''){
        alert('Thao tác xóa bị lỗi');
    }else{
        $.ajax({
            type: 'post',
            url: 'calendar_admin.php',
            dataType: 'JSON',
            data: {
                checking_cancel: true,
                idcancel_calendar: idcancel_calendar
            },
            success: function(data) {
                console.log(data)
                setTimeout(function(){
                    $('#cancel-calendar').modal('hide');
                    location.reload();
                }, 1000);
            }
        })
    }
})
//Show modal accept calender
$(document).ready(function () {
    $(".click-accept-calender").click(function () {
        $('#accept-calendar').modal({
            backdrop: 'static',
            keyboard: false
        });
        
        var id_calendar_admin = $(this).closest('tr').find('#id_calendar_admin').text();
        $('#iduser_calendar').val(id_calendar_admin);
    });
});
$(document).on('click', '#btn_accept_calendar', function(){
    var id_calendar_admin = $('#iduser_calendar').val()
    console.log(id_calendar_admin);
    if(id_calendar_admin ==''){
        alert('Thao tác duyệt bị lỗi');
    }
    else{
        $.ajax({
            type: 'post',
            url: 'calendar_admin.php',
            dataType: 'JSON',
            data: {
                checking_accept: true,
                id_calendar_admin: id_calendar_admin
            },
            success: function(data) {
                //console.log(data)
                setTimeout(function(){
                    $('#accept-calendar').modal('hide');
                    location.reload();
                }, 1000);
            }
        })
    }
})
//Show modal create calendar
$(document).ready(function () {
    $(".create-calender-tp").click(function () {
        $('#create-calendar').modal({
            backdrop: 'static',
            keyboard: false
        });
    
    });
});
$(document).on('click', '#btn-create-calender-tp', function(){
    var username = $('#user_tp_create').val();
    var ngayBatDau = $('#from_date').val();
    var ngayKetThuc = $('#to_date').val();
    var liDo = $('#reason').val();
    var ngayConLai = $('#rest_day').val();
    var date1 = new Date(ngayBatDau);
    var date2 = new Date(ngayKetThuc);
    var difference = date2.getTime() - date1.getTime();
    var days = Math.ceil(difference / (1000 * 3600 * 24));
    (ngayBatDau == '') ? $('#err-from-date').html('Vui lòng chọn ngày bắt đầu nghỉ!'): $('#err-from-date').html('');
    (ngayKetThuc == '') ? $('#err-to-date').html('Vui lòng chọn ngày kết thúc!'): $('#err-to-date').html('');
    (liDo == '') ? $('#err-reason').html('Vui lòng nhập lý do nghỉ!'): $('#err-reason').html('');
    (days >= ngayConLai) ? $('#err-to-date').html('Số ngày nghỉ của bạn đã vượt quá giá hạn!'): $('#err-to-date').html('');
    console.log(username, ngayBatDau, ngayKetThuc, liDo, ngayConLai);
    if (ngayBatDau != '' && ngayKetThuc != '' && liDo != '') {
        $.ajax({
            type: 'post',
            dataType: 'JSON',
            url: 'calendar_manager.php',
            data: {
                username: username,
                ngayBatDau: ngayBatDau,
                ngayKetThuc: ngayKetThuc,
                liDo: liDo,
                ngayConLai: ngayConLai,
            },
            success: function(data) {
                if (data.hasOwnProperty('error') && data.error == '1') {
                    var html = '';
                    $.each(data, function(key, item) {
                        if (key != 'error') {
                            html += '<li>' + item + '</li>';
                        }
                    });
                    $('.alert-danger').html(html).removeClass('hide');
                } else { // Thành công
                    $('.alert-success').html('Tạo đơn xin nghỉ phép thành công!');
                    // 1 giay sau sẽ tắt popup
                    setTimeout(function() {
                        $('#create-calendar').modal('hide');
                        location.reload();
                    }, 1000);

                }
            }
        })
    }

})

//Calendar bên trưởng phòng
//Show modal upload profile
$(document).ready(function () {
    $(".click-update-image").click(function () {
        $('#upload-profile').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
});

$(document).ready(function(){
    
    imgInp.onchange = e => {
        const [file] = imgInp.files;
        if (file) {
            img_preview.src = URL.createObjectURL(file);
        }
    }
    $('#btn_upload').click(function(){
        var postData =  new FormData($("#form-upload-img")[0]);
        console.log(postData);
        $.ajax({
            type:'POST',
            url:'profile.php',
            enctype : 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data : postData,
            success:function(data){
                //console.log(data)
                $('#upload-profile').modal('hide');
            }
        })
    });
});
// Manager Task
// new task
$(document).ready(function () {
    $(".click-create-task").click(function () {
        $('#new-task').modal({
            backdrop: 'static',
            keyboard: true, 
        });
    });
});
// view task
$(document).ready(function () {
    $(".click-preview-task").click(function () {
        $('#preview-task').modal({
            backdrop: 'static',
            keyboard: true, 
        });
    });
});
// view task employee
$(document).ready(function () {
    $("#click_start_task_employee").click(function () {
        $('#start_task_employee').modal({
            backdrop: 'static',
            keyboard: true, 
        });
    });
});
//delete task
$(document).ready(function () {
    $(".click-delete-task").click(function () {
        $('#delete-task').modal({
            backdrop: 'static',
            keyboard: true, 
        });
    });
});
//edit task
$(document).ready(function () {
    $(".click-update-task").click(function () {
        $('#update-task').modal({
            backdrop: 'static',
            keyboard: true, 
        });
    });
});
//submit task
$(document).ready(function () {
    $(".click-submit-task").click(function () {
        $('#submit-task').modal({
            backdrop: 'static',
            keyboard: true, 
        });
    });
});
//view submit task
$(document).ready(function () {
    $(".click-view-submit-task").click(function () {
        $('#view-submit-task').modal({
            backdrop: 'static',
            keyboard: true, 
        });
    });
});
//upload file
function myFunction(){
    var x = document.getElementById("myFile");
    var txt = "";
    if('files' in x){
        if(x.files.length == 0){
            txt = "Select one or more files.";
        }else{
            for(var i=0; i<x.files.length; i++){
                txt += "<br><strong>" + (i+1) + ". file</strong><br>";
                var file = x.files[i];
                if('name' in file){
                    txt += "name: " + file.name + "bytes <br>";
                }if('size' in file){
                    txt += "size: " + file.size + "bytes <br>";
                }
            }
        }
    }
    else {
        if (x.value == ""){
            txt += "Select one or more file.";
        }else{
            txt += "The type file is not supported.";
            txt += "<br>The path of the select file: " + x.value;
        }
    }
    document.getElementById("demo").innerHTML = txt;
}
// submit file
function submitFile(){
    var x = document.getElementById("subFile");
    var txt = "";
    if('files' in x){
        if(x.files.length == 0){
            txt = "Select one or more files.";
        }else{
            for(var i=0; i<x.files.length; i++){
                txt += "<br><strong>" + (i+1) + ". file</strong><br>";
                var file = x.files[i];
                if('name' in file){
                    txt += "name: " + file.name + "bytes <br>";
                }if('size' in file){
                    txt += "size: " + file.size + "bytes <br>";
                }
            }
        }
    }
    else {
        if (x.value == ""){
            txt += "Select one or more file.";
        }else{
            txt += "The type file is not supported.";
            txt += "<br>The path of the select file: " + x.value;
        }
    }
    document.getElementById("view_file_submit").innerHTML = txt;
}

const currentLocation = location.href;
const menuitem = document.querySelectorAll('a');
const menuLength = menuitem.length;
for(let i=0; i<menuLength; i++){
    if(menuitem[i].href === currentLocation){
        menuitem[i].className = "active";
    }
}
function toggleResult(){
    var x = document.getElementById("result_calendar_mn");
    if (x.style.display == "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
   
}






