function editData(id){
    $.ajax({
        url: path+'/'+id,
        type: 'GET',
        success: function(data){
            $("input[name='id']").val(data.id);
            $("input[name='name']").val(data.menu_name);
            $("input[name='slug']").val(data.slug);
            if(data.active == 1){
                $("input[name='active']").prop('checked', true);
            }else{
                $("input[name='active']").prop('checked', false);
            }
        }
    });
}
$(document).on('click', '.add-new', function(){
    document.getElementById("add-form").reset();
});
var arrayId = [];
function checkAllForm(ele, event) {
    var checkboxes = document.getElementById('editRoleForm_'+ele);
    //get all the inputs within the table
    var inputs = checkboxes.getElementsByTagName('input');
    //loop through all the inputs
    var arrayId2 = [];
    for (var i = 2; i < inputs.length; i++) {
        //if the input has the class "check-all" attached to it...
        if (inputs[i].type === 'checkbox' && inputs[i].checked) {
            //get id of the input
            arrayId2.push(inputs[i].id);
        }
    }
     if (event.checked) {
        arrayId.push(arrayId2);
        console.log(inputs);
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == 'checkbox') {
                console.log(inputs[i].id);
                $("#"+inputs[i].id).prop('checked', true);
            }
        }
        console.log(arrayId);
    } else {
        arrayId.push(arrayId2);
        for (var i = 2; i < inputs.length; i++) {
            if (inputs[i].type == 'checkbox') {
                // inputs[i].checked = false;
                $("#"+inputs[i].id).prop('checked', false);
                document.getElementById(inputs[i].id).checked = false;
            }
        }
    }
}
let arrayIds = [];
function resetCheck(ele){
    arrayId = [];
    let checkboxes = document.getElementById('editRoleForm_'+ele);
    //get all the inputs within the table
    let inputs = checkboxes.getElementsByTagName('input');
    //loop through all the inputs
    for (let i = 0; i < inputs.length; i++) {
        //if the input has the class "check-all" attached to it...
        if (inputs[i].type === 'checkbox' && inputs[i].checked) {
            //get id of the input
            let id = inputs[i].id;
            arrayIds.push(id);
        }
    }
    for(let j =2; j < arrayIds.length; j++){
        $(arrayIds[j]).prop('checked', true);
    }
}
function rollbackCheck(){
    for(var j = 0; j < (arrayId[0].length); j++){
        //checked by element id
        if( j != 1){
            document.getElementById(arrayId[0][j]).checked = true;
        }
    }
}
function removeData(id){
    remove('Data yang berelasi akan terhapus!', path+'-delete/'+id, fetch)
}
$(function () {
    $('#add-form').on('submit', function(e) {
        $("#loading-login").show();
        $("#submit").hide('fadeOut');
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: path,
            dataType : 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $("#add-form").serialize(),
            success: function( msg ) {
                 //success
                 toastr['success'](
                    'Data Updated!',
                    '👋 Data berhasil diupdate!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
                setTimeout(function () {
                    window.location.href = fetch
                }, 400);
            },
            error : function(msg){
                $("#error").show()
                //show message error array
                var htmlError = '<ol>';
                $.each(msg.responseJSON.errors, function(key, value){
                    htmlError+='<li>'+value[0]+'</li>';
                });
                htmlError+='</ol>';
                $("#message-error").html(htmlError);
                $("#loading-login").hide();
                $("#submit").show('fadeOut');
            }
        });
    });

  });
