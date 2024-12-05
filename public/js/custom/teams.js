function delay(callback, ms) {
    // alert(ms);
    var timer = 0;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

let department_sale = 3;
$(document).ready(function () {
    $("#leader_id,#user_id").select2({
        dropdownParent: $("#add_new_form"),
        placeholder: 'Chọn',
        width: '100%',
        allowClear: true
    });
});
$(document).on('keyup', '#search', delay(function () {
    // e.preventDefault();
    let search = $(this).val();
    $.ajax({
        url: "/teams",
        method: "get",
        data: {
            name: search,
        }
    }).done(function (data) {
        $('#registration-form').html(data);
    });
}, 500));

$("#team-my-form").validate({
    rules: {
        department_id: "required",
        name: "required",
        code: "required",
        leader_id: "required"
    },
});

//add team
$(document).on('click', '#add_new', async function () {
    resetValue();
    await getLeaderTeam();
    $('#add_new_form').modal({show: true})
});

// edit
$(document).on('click', '.edit', async function () {
    let team = $(this).data('team');
    await getLeaderTeamEdit(team.department_id,team.id);
    let teamMember = $(this).data('member');
    teamMember = teamMember.map(m => m.toString());
    let form = $('#team-my-form');
    form.attr('action', '/teams/' + team.id);
    form.attr('method', 'POST');
    $('#myModalLabel35').html('Cập nhật thông tin đội, nhóm').change();
    form.append('<input name="_method" type="hidden" value="PUT" class="_method" />');

    $('#department_id').val(team.department_id).change();
    $('#code').val(team.code);
    $('#name').val(team.name);
    $('#depot_id').val(team.depot_id).trigger('change');
    $('#cskh_id').val(team.cskh_id).trigger('change');
    $('#leader_id').val(team.leader_id.toString()).trigger('change');
    $('#user_id').val(teamMember).change();
    $('#add_new_form').modal({show: true})
});

// Chọn kiểu nhóm
$('#department_id').on('select2:select', function (e) {
    getLeaderTeam(e.target.value);
});

async function getLeaderTeam(department_id = department_sale) {
    let html = '';
    let row = $('body').find('#leader_id');
    let row1 = $('body').find('#user_id');
    await $.ajax({
        url: '/ajax/get-all-user-department-not-team',
        data:{
            department: department_id
        },
        success: function (data) {
            if (data.user && data.user.length > 0) {
                let user = data.user;
                console.log('usersssss',user)
                user.forEach(element => {
                    html += `
                                <option value='` + element.id + `'>` + element.full_name + `</option>
                            `;
                    row.html(html);
                    row1.html(html);
                });
            } else {
                row.html(html);
                row1.html(html);
            }
        }
    })
};

//get nhân viên chưa có team và nhân viên có trong team đang chọn
async function getLeaderTeamEdit(department_id,team_id) {
    let html = '';
    let row = $('body').find('#leader_id');
    let row1 = $('body').find('#user_id');
    await $.ajax({
        url: '/ajax/get-all-user-department-team',
        data:{
            department: department_id,
            team_id: team_id
        },
        success: function (data) {
            if (data.user && data.user.length > 0) {
                let user = data.user;
                user.forEach(element => {
                    html += `
                                <option value='` + element.id + `'>` + element.full_name + `</option>
                            `;
                    row.html(html);
                    row1.html(html);
                });
            } else {
                row.html(html);
                row1.html(html);
            }
        }
    })
};

function resetValue() {
    let form = $('#team-my-form');
    form.attr('action', '/teams');
    $('._method').remove();
    $('#department_id').val(department_sale).change();
    $('#code').val('');
    $('#name').val('');
    $('#leader_id').val({}).change();
    $('#depot_id').val({}).change();
    $('#user_id').val([]).change();
};
