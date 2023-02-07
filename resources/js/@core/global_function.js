export const func = {
    notifAlert : function(varicon, vartitle, vartext, custom = null){
                var optionSwal = {
                    icon: varicon,
                    title: vartitle,
                    text: vartext
                }
                if(custom){
                   optionSwal =  Object.assign(custom, optionSwal)
                }
                return optionSwal;
                // this.$swal(optionSwal)
    },
    notifToast : function(varType, varText, varPosition){
        this.$toasted.show(varText, {
            position : varPosition, //['top-right', 'top-center', 'top-left', 'bottom-right', 'bottom-center', 'bottom-left']
            type : varType, //Type of the Toast ['success', 'info', 'error']
            theme : 'toasted-primary', //['toasted-primary', 'outline', 'bubble']
            iconPack : 'material',
        })
    }
}
