
function crpAjaxGetPortfolioWithId(pid){
    if(!pid){
        return null;
    }

    var result;
    var sendData = {
        action: 'crp_get_portfolio',
        id: pid,
    };
    jQuery.ajax ( {
            type		:	'get',
            data        :   sendData,
            url			: 	CRP_AJAX_URL,
            dataType	: 	'json',
            async       :   false,
            success		: 	function( response ) {
                result = crpAjaxResponseValidate(response);
                if(result){
                    var portfolio = response.portfolio;
                    result = response.portfolio;
                }
            },
            error:function( response ) {
                alert(JSON.stringify(response));
                result = null;
            }
     } );

    return result;
}


function crpAjaxSavePortfolio(portfolio){
    if(!portfolio){
        return null;
    }

    var result;
    var sendData = {
        action: 'crp_save_portfolio',
        portfolio: JSON.stringify(portfolio),
    };
    jQuery.ajax ( {
            type		:	'post',
            data        :   sendData,
            url			: 	CRP_AJAX_URL,
            dataType	: 	'html',
            async       :   false,
            success		: 	function( response ) {
                try{
                    result = JSON.parse(response)
                    result = crpAjaxResponseValidate(result);
                }catch(error){
                    result = null;
                }
            },
            error:function( response ) {
                alert(JSON.stringify(response));
                result = null;
            }
     } );

     return result;
}

function crpAjaxGetOptionsWithPid(pid){
    if(!pid){
        return null;
    }

    var result;
    var sendData = {
        action: 'crp_get_options',
        id: pid,
    };
    jQuery.ajax ( {
        type		:	'get',
        data        :   sendData,
        url			: 	CRP_AJAX_URL,
        dataType	: 	'json',
        async       :   false,
        success		: 	function( response ) {
            result = crpAjaxResponseValidate(response);
            if(result){
                result = response.options;
            }
        },
        error:function( response ) {
            alert(JSON.stringify(response));
            result = null;
        }
    } );

    return result;
}


function crpAjaxSaveOptionsWithPid(options, pid){
    if(!options || !pid){
        return null;
    }

    var result;
    var sendData = {
        action: 'crp_save_options',
        options: options,
        pid: pid
    };
    jQuery.ajax ( {
        type		:	'post',
        data        :   sendData,
        url			: 	CRP_AJAX_URL,
        dataType	: 	'html',
        async       :   false,
        success		: 	function( response ) {
            try{
                result = JSON.parse(response)
                result = crpAjaxResponseValidate(result);
            }catch(error){
                result = null;
            }
        },
        error:function( response ) {
            alert(JSON.stringify(response));
            result = null;
        }
    } );

    return result;
}


//Helper functions
function crpAjaxResponseValidate(response){
    if(!response) return null;

    if(response.status != 'success'){
        alert(JSON.stringify(response.errormsg));
        return null;
    }

    return response;
}