
//get search api push directory table
const changeDirectory = (params) => {
    if(params == "extension"){
        changeExtension(params);
    }
    else if( params == "emergency"){
        changeEmergency(params);
    }
}

const changeExtension = (params) => {
    let url = `${urlPost}`;
    $.ajax({
        url: url,
        type: 'GET',
        data: 'directory='+params+'&q='+$("input[name='q']").val(),
        dataType: 'json',
        success: function (data) {
            if (data) {
                let html = '';
                let data_length = data.data.length;
                if (data_length > 0) {
                    $.each(data.data, function (key, value) {
                        let name = (value.name == null) ? '-' : value.name;
                        let position = (value.position == null) ? '-' : value.position;
                        let ext = (value.ext == null) ? '-' : value.ext;
                        let division = (value.division == null) ? '-' : value.division;
                        let location = (value.location == null) ? '-' : value.location;
                        let lantai = (value.lantai == null) ? '-' : value.lantai;
                        let departement = (value.departement == null) ? '-' : value.departement;
                        html += `<tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar rounded">
                                                <div class="avatar-content rounded" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up my-0" title="" data-bs-original-title="${name}">
                                                    <img src="/app-assets/images/portrait/small/avatar-s-9.jpg" alt="" width="50" height="50" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bolder">${name}</div>
                                                <div class="font-small-2 text-muted">${position}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-light-primary me-1">
                                                <div class="avatar-content">
                                                    <i data-feather="monitor" class="font-medium-3"></i>
                                                </div>
                                            </div>
                                            <span>${departement}</span>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bolder mb-25">${lantai}</span>
                                        </div>
                                    </td>
                                    <td>${ext}</td>
                                    <td>${division}</td>
                                    <td>${location}</td>
                                </tr>`;
                    });
                } else {
                    html = `<tr>
                                <td colspan="11">No data found</td>
                            </tr>`;
                }
                $(".table-emergency").hide();
                $(".table-emergency-get").hide();
                $(".table-extension").show('slow');
                $(".table-extension-get").hide('slow');
                $('#data-extension').html(html);
            } else {
                alert('Something went wrong');
            }
        }
    });
} //end of changeDirectory


const changeEmergency = (params) => {
    let url = `${urlPost}`;
    $.ajax({
        url: url,
        type: 'GET',
        data: 'directory='+params+'&q='+$("input[name='q']").val(),
        dataType: 'json',
        success: function (data) {
            if (data) {
                let html = '';
                let data_length = data.data.length;
                if (data_length > 0) {
                    $.each(data.data, function (key, value) {
                        html += `<tr class="info">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-light-primary me-1">
                                                <div class="avatar-content">
                                                    <i data-feather="phone-call" class="font-medium-3"></i>
                                                </div>
                                            </div>
                                            <span>${value.name}</span>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bolder mb-25">${value.phone}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bolder mb-25">${value.position}</span>
                                    </td>
                               </tr>`;
                    });
                } else {
                    html = `<tr>
                                <td colspan="11">No data found</td>
                            </tr>`;
                }
                $(".table-extension").hide('slow');
                $(".table-emergency-get").hide('slow');
                $(".table-emergency").show('slow');
                $('#data-emergency').html(html);
            } else {
                alert('Something went wrong');
            }
        }
    });
} //end of changeDirectory
